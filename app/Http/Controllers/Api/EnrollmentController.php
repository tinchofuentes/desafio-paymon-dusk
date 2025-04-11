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
            $enrollment = Enrollment::create([
                'course_id' => $validated['course_id'],
                'student_id' => $validated['student_id'],
                'enrollment_date' => $validated['enrollment_date'],
                'notes' => $validated['notes'] ?? null,
            
            ]);
            
            if (isset($validated['initial_payment']) && $validated['initial_payment'] > 0) {
                $payment = new Payment([
                    'amount' => $validated['initial_payment'],
                    'method' => $validated['payment_method'],
                    'status' => PaymentStatus::PENDING,
                    'payment_date' => now(),
                    'notes' => 'Pago inicial de matrícula',
                ]);
                
                $enrollment->payments()->save($payment);
            }
            
            if (isset($validated['guardian_id'])) {
                $guardian = Guardian::findOrFail($validated['guardian_id']);
                
                $studentHasGuardian = $guardian->students()->where('id', $validated['student_id'])->exists();
                
                if (!$studentHasGuardian) {
                    throw new \InvalidArgumentException('El tutor no está asociado con el estudiante');
                }
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
        $enrollment->update($request->validated());
        
        return new EnrollmentResource($enrollment);
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
