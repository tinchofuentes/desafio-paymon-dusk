<?php

namespace App\Http\Requests;

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
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'modality' => ['required', Rule::in([CourseModality::IN_PERSON, CourseModality::ONLINE, CourseModality::HYBRID])],
            'active' => 'boolean',
            'capacity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }
}
