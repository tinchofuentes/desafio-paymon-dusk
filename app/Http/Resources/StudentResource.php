<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender ? [
                'value' => $this->gender->value,
                'label' => $this->gender->label(),
            ] : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'guardian' => new GuardianResource($this->whenLoaded('guardian')),
            'enrollments' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'enrollments_count' => $this->when(
                $this->enrollments_count !== null, 
                $this->enrollments_count
            ),
        ];
    }
}
