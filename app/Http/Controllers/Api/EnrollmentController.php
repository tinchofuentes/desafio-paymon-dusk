<?php

namespace App\Http\Controllers\Api;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Student;
use App\OpenApi\Controllers\EnrollmentControllerDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

/**
 * @see EnrollmentControllerDoc for API documentation
 */
class EnrollmentController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Enrollment::query();
        
        if ($request->has('course_id')) {
            $query->where('course_id', $request->input('course_id'));
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        
        if ($request->has('from_date')) {
            $query->whereDate('enrollment_date', '>=', $request->input('from_date'));
        }
        
        if ($request->has('to_date')) {
            $query->whereDate('enrollment_date', '<=', $request->input('to_date'));
        }
        
        $with = [];
        if ($request->boolean('with_student')) {
            $with[] = 'student';
        }
        
        if ($request->boolean('with_course')) {
            $with[] = 'course';
        }
        
        if ($request->boolean('with_payments')) {
            $with[] = 'payments';
        }
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        $enrollments = $query->paginate($request->input('per_page', 15));
        
        return EnrollmentResource::collection($enrollments);
    }

    public function store(EnrollmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validated();
            
            $guardian = Guardian::firstOrCreate(
                ['email' => $validated['guardian_email']],
                [
                    'name' => $validated['guardian_name'],
                    'phone' => $validated['guardian_phone'],
                ]
            );
            
            $student = Student::create([
                'guardian_id' => $guardian->id,
                'first_name' => $validated['student_first_name'],
                'last_name' => $validated['student_last_name'],
                'birth_date' => $validated['student_birth_date'],
                'gender' => $validated['student_gender'] ?? null,
            ]);
            
            $enrollment = Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $validated['course_id'],
                'enrollment_date' => $validated['enrollment_date'] ?? now(),
                'status' => $validated['status'] ?? EnrollmentStatus::PENDING,
                'notes' => $validated['notes'] ?? null,
            ]);
            
            if (isset($validated['payment_amount']) && $validated['payment_amount'] > 0) {
                $payment = new Payment([
                    'amount' => $validated['payment_amount'],
                    'method' => $validated['payment_method'],
                    'status' => $validated['payment_status'] ?? PaymentStatus::PENDING,
                    'payment_date' => now(),
                    'reference_number' => $validated['reference_number'] ?? null,
                    'notes' => 'Pago inicial de matrícula',
                ]);
                
                $enrollment->payments()->save($payment);
            }
            
            DB::commit();
            
            $enrollment->load(['student', 'course', 'payments']);
            
            return (new EnrollmentResource($enrollment))
                ->response()
                ->setStatusCode(201);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Error al crear la matrícula: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, Enrollment $enrollment): EnrollmentResource
    {
        $with = [];
        
        if ($request->boolean('with_student')) {
            $with[] = 'student';
        }
        
        if ($request->boolean('with_course')) {
            $with[] = 'course';
        }
        
        if ($request->boolean('with_payments')) {
            $with[] = 'payments';
        }
        
        if (!empty($with)) {
            $enrollment->load($with);
        }
        
        return new EnrollmentResource($enrollment);
    }

    public function update(EnrollmentRequest $request, Enrollment $enrollment): EnrollmentResource
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validated();
            
            if (isset($validated['student_first_name']) || isset($validated['student_last_name']) || 
                isset($validated['student_birth_date']) || isset($validated['student_gender'])) {
                
                $student = $enrollment->student;
                
                if ($student) {
                    $studentData = [];
                    
                    if (isset($validated['student_first_name'])) {
                        $studentData['first_name'] = $validated['student_first_name'];
                    }
                    
                    if (isset($validated['student_last_name'])) {
                        $studentData['last_name'] = $validated['student_last_name'];
                    }
                    
                    if (isset($validated['student_birth_date'])) {
                        $studentData['birth_date'] = $validated['student_birth_date'];
                    }
                    
                    if (isset($validated['student_gender'])) {
                        $studentData['gender'] = $validated['student_gender'];
                    }
                    
                    $student->update($studentData);
                    
    
                    $guardian = $student->guardian;
                    
                    if ($guardian && (isset($validated['guardian_name']) || isset($validated['guardian_email']) || 
                        isset($validated['guardian_phone']))) {
                        
                        $guardianData = [];
                        
                        if (isset($validated['guardian_name'])) {
                            $guardianData['name'] = $validated['guardian_name'];
                        }
                        
                        if (isset($validated['guardian_email'])) {
                            $guardianData['email'] = $validated['guardian_email'];
                        }
                        
                        if (isset($validated['guardian_phone'])) {
                            $guardianData['phone'] = $validated['guardian_phone'];
                        }
                        
                        $guardian->update($guardianData);
                    }
                }
            }
            
            $enrollmentData = [];
            
            if (isset($validated['course_id'])) {
                $enrollmentData['course_id'] = $validated['course_id'];
            }
            
            if (isset($validated['enrollment_date'])) {
                $enrollmentData['enrollment_date'] = $validated['enrollment_date'];
            }
            
            if (isset($validated['status'])) {
                $enrollmentData['status'] = $validated['status'];
            }
            
            if (isset($validated['notes'])) {
                $enrollmentData['notes'] = $validated['notes'];
            }
            
            if (!empty($enrollmentData)) {
                $enrollment->update($enrollmentData);
            }
            
            if (isset($validated['payment_method']) || isset($validated['payment_amount'])) {
                $payment = $enrollment->payments->first();
                
                $paymentData = [
                    'method' => $validated['payment_method'] ?? $payment?->method,
                    'amount' => $validated['payment_amount'] ?? $payment?->amount,
                    'status' => $validated['payment_status'] ?? $payment?->status ?? PaymentStatus::PENDING,
                    'reference_number' => $validated['reference_number'] ?? $payment?->reference_number,
                ];
                
                if ($payment) {
                    $payment->update($paymentData);
                } else {
                    $paymentData['payment_date'] = now();
                    $paymentData['enrollment_id'] = $enrollment->id;
                    Payment::create($paymentData);
                }
            }
            
            DB::commit();
            
            $enrollment->load(['student.guardian', 'course', 'payments']);
            
            return new EnrollmentResource($enrollment);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw $e;
        }
    }

    public function destroy(Enrollment $enrollment): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $enrollment->payments()->delete();
            
            $enrollment->delete();
            
            DB::commit();
            
            return response()->json(null, 204);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Error al eliminar la matrícula: ' . $e->getMessage()
            ], 500);
        }
    }
}
