<?php

namespace App\Http\Requests\Api;

use App\Enums\CourseModality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
            'academy_id' => 'required|exists:academies,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'modality' => ['required', Rule::enum(CourseModality::class)],
            'active' => 'boolean',
            'capacity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
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
            'academy_id.required' => 'Debe seleccionar una academia',
            'academy_id.exists' => 'La academia seleccionada no existe',
            'name.required' => 'El nombre del curso es obligatorio',
            'description.required' => 'La descripción del curso es obligatoria',
            'cost.required' => 'El costo del curso es obligatorio',
            'cost.numeric' => 'El costo debe ser un valor numérico',
            'cost.min' => 'El costo no puede ser negativo',
            'duration.required' => 'La duración del curso es obligatoria',
            'duration.integer' => 'La duración debe ser un número entero',
            'duration.min' => 'La duración mínima es de 1 hora',
            'modality.required' => 'La modalidad del curso es obligatoria',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser posterior a la fecha de inicio',
        ];
    }
}
