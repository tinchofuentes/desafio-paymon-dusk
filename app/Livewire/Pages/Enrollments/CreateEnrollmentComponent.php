<?php

namespace App\Livewire\Pages\Enrollments;

use App\Enums\EnrollmentStatus;
use App\Enums\Gender;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Course;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class CreateEnrollmentComponent extends Component
{
    // Datos del estudiante
    #[Validate('required|string|max:255')]
    public $student_first_name = '';
    
    #[Validate('required|string|max:255')]
    public $student_last_name = '';
    
    #[Validate('required|date')]
    public $student_birth_date = '';
    
    #[Validate('nullable|string')]
    public $student_gender = '';
    
    // Datos del apoderado
    #[Validate('required|string|max:255')]
    public $guardian_name = '';
    
    #[Validate('required|email|max:255')]
    public $guardian_email = '';
    
    #[Validate('required|string|max:20')]
    public $guardian_phone = '';
    
    // Datos de la inscripción
    #[Validate('required|exists:courses,id')]
    public $course_id = '';
    
    // Datos del pago
    #[Validate('required|string')]
    public $payment_method = '';
    
    #[Validate('nullable|string')]
    public $reference_number = '';
    
    public $course_cost = 0;
    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Reglas de validación agrupadas por pasos
    protected $guardianRules = [
        'guardian_name' => 'required|string|max:255',
        'guardian_email' => 'required|email|max:255',
        'guardian_phone' => 'required|string|max:20',
    ];
    
    protected $studentRules = [
        'student_first_name' => 'required|string|max:255',
        'student_last_name' => 'required|string|max:255',
        'student_birth_date' => 'required|date',
        'student_gender' => 'nullable|string',
        'course_id' => 'required|exists:courses,id',
    ];
    
    protected $paymentRules = [
        'payment_method' => 'required|string',
    ];
    
    public function mount($course = null)
    {
        $this->student_birth_date = now()->subYears(10)->format('Y-m-d');
        
        if ($course) {
            $this->course_id = $course;
            $this->updatedCourseId();
        }
    }
    
    public function updatedCourseId()
    {
        if ($this->course_id) {
            $course = Course::find($this->course_id);
            if ($course) {
                $this->course_cost = $course->cost;
            }
        } else {
            $this->course_cost = 0;
        }
    }
    
    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate($this->guardianRules);
        } elseif ($this->currentStep === 2) {
            $this->validate($this->studentRules);
        }
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
    
    public function submit()
    {
        // Validar datos de pago
        $paymentRules = $this->paymentRules;
        if ($this->payment_method === PaymentMethod::BANK_TRANSFER->value) {
            $paymentRules['reference_number'] = 'required|string';
        } else {
            $paymentRules['reference_number'] = 'nullable|string';
        }
        
        $this->validate($paymentRules);
        
        try {
            DB::beginTransaction();
            
            // Crear o actualizar el apoderado
            $guardian = Guardian::firstOrCreate(
                ['email' => $this->guardian_email],
                [
                    'name' => $this->guardian_name,
                    'phone' => $this->guardian_phone,
                ]
            );
            
            // Crear estudiante
            $student = Student::create([
                'guardian_id' => $guardian->id,
                'first_name' => $this->student_first_name,
                'last_name' => $this->student_last_name,
                'birth_date' => $this->student_birth_date,
                'gender' => $this->student_gender,
            ]);
            
            // Crear matrícula
            $enrollment = Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $this->course_id,
                'enrollment_date' => now(),
                'status' => EnrollmentStatus::PENDING->value,
            ]);
            
            // Registrar pago
            Payment::create([
                'enrollment_id' => $enrollment->id,
                'amount' => $this->course_cost,
                'method' => $this->payment_method,
                'status' => PaymentStatus::PENDING->value,
                'payment_date' => now(),
                'reference_number' => $this->reference_number,
            ]);
            
            DB::commit();
            
            session()->flash('message', '¡Inscripción realizada con éxito! Pronto nos pondremos en contacto contigo.');
            
            return redirect()->route('enrollment.confirmation', $enrollment->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ha ocurrido un error al procesar la inscripción. Por favor, inténtalo de nuevo.');
        }
    }
    
    public function render()
    {
        return view('livewire.pages.enrollments.create-enrollment-component', [
            'course' => Course::find($this->course_id),
            'courses' => Course::where('active', true)->get(),
            'paymentMethods' => PaymentMethod::options(),
            'genderOptions' => Gender::options(),
        ]);
    }
}
