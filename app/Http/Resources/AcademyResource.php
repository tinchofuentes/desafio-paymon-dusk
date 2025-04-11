<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademyResource extends JsonResource
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
            'logo' => $this->logo,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courses' => CourseResource::collection(
                $this->whenLoaded('courses', function () {
                    return $this->courses->where('active', true);
                })
            ),
            'courses_count' => $this->when(
                $this->courses_count !== null, 
                $this->courses_count
            ),
        ];
    }
}
