<?php

namespace App\Http\Requests\Api;

use App\Enums\EnrollmentStatus;
use App\Enums\Gender;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Guardian data
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email|max:255',
            'guardian_phone' => 'required|string|max:20',
            
            // Student data
            'student_first_name' => 'required|string|max:255',
            'student_last_name' => 'required|string|max:255',
            'student_birth_date' => 'required|date',
            'student_gender' => ['nullable', Rule::enum(Gender::class)],
            
            // Enrollment data
            'course_id' => 'required|exists:courses,id',
            'enrollment_status' => ['nullable', Rule::enum(EnrollmentStatus::class)],
            
            // Payment data
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'payment_amount' => 'required|numeric|min:0',
            'payment_status' => ['nullable', Rule::enum(PaymentStatus::class)],
            'reference_number' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'guardian_name.required' => 'El nombre del apoderado es obligatorio',
            'guardian_email.required' => 'El correo electrónico del apoderado es obligatorio',
            'guardian_email.email' => 'Debe ingresar un correo electrónico válido',
            'guardian_phone.required' => 'El teléfono del apoderado es obligatorio',
            
            'student_first_name.required' => 'El nombre del estudiante es obligatorio',
            'student_last_name.required' => 'El apellido del estudiante es obligatorio',
            'student_birth_date.required' => 'La fecha de nacimiento del estudiante es obligatoria',
            'student_birth_date.date' => 'Debe ingresar una fecha válida',
            
            'course_id.required' => 'Debe seleccionar un curso',
            'course_id.exists' => 'El curso seleccionado no existe',
            
            'payment_method.required' => 'Debe seleccionar un método de pago',
            'payment_amount.required' => 'El monto del pago es obligatorio',
            'payment_amount.numeric' => 'El monto debe ser un valor numérico',
            'payment_amount.min' => 'El monto no puede ser negativo',
        ];
    }
}
