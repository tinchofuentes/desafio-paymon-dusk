<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'duration' => $this->duration,
            'modality' => [
                'value' => $this->modality->value,
                'label' => $this->modality->label(),
            ],
            'active' => $this->active,
            'capacity' => $this->capacity,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'academy' => new AcademyResource($this->whenLoaded('academy')),
            'enrollments_count' => $this->when(
                $this->enrollments_count !== null, 
                $this->enrollments_count
            ),
        ];
    }
}
