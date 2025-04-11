<?php

namespace App\Http\Requests\Api;

use App\Enums\CommunicationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommunicationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'age_from' => 'nullable|integer|min:1|max:99',
            'age_to' => 'nullable|integer|min:1|max:99|gte:age_from',
            'send_date' => 'nullable|date',
            'status' => ['required', Rule::enum(CommunicationStatus::class)],
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
            'title.required' => 'El título del comunicado es obligatorio',
            'message.required' => 'El mensaje del comunicado es obligatorio',
            'course_id.exists' => 'El curso seleccionado no existe',
            'age_from.integer' => 'La edad mínima debe ser un número entero',
            'age_from.min' => 'La edad mínima debe ser al menos 1 año',
            'age_from.max' => 'La edad mínima no puede superar los 99 años',
            'age_to.integer' => 'La edad máxima debe ser un número entero',
            'age_to.min' => 'La edad máxima debe ser al menos 1 año',
            'age_to.max' => 'La edad máxima no puede superar los 99 años',
            'age_to.gte' => 'La edad máxima debe ser mayor o igual que la edad mínima',
            'send_date.date' => 'Debe ingresar una fecha válida',
            'status.required' => 'El estado del comunicado es obligatorio',
        ];
    }
}
