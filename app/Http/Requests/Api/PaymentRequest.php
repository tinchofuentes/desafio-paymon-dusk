<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            'enrollment_id' => 'required|exists:enrollments,id',
            'amount' => 'required|numeric|min:0',
            'method' => ['required', Rule::enum(PaymentMethod::class)],
            'status' => ['nullable', Rule::enum(PaymentStatus::class)],
            'payment_date' => 'required|date',
            'reference_number' => [
                Rule::when(
                    request('method') === PaymentMethod::BANK_TRANSFER->value,
                    ['required', 'string', 'max:255'],
                    ['nullable', 'string', 'max:255']
                ),
            ],
            'notes' => 'nullable|string',
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
            'enrollment_id.required' => 'La matrícula es obligatoria',
            'enrollment_id.exists' => 'La matrícula seleccionada no existe',
            'amount.required' => 'El monto del pago es obligatorio',
            'amount.numeric' => 'El monto debe ser un valor numérico',
            'amount.min' => 'El monto no puede ser negativo',
            'method.required' => 'El método de pago es obligatorio',
            'payment_date.required' => 'La fecha de pago es obligatoria',
            'payment_date.date' => 'La fecha de pago debe ser una fecha válida',
            'reference_number.required' => 'El número de referencia es obligatorio para transferencias bancarias',
        ];
    }
} 