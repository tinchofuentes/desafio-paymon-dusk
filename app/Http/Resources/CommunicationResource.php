<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
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
            'title' => $this->title,
            'message' => $this->message,
            'age_from' => $this->age_from,
            'age_to' => $this->age_to,
            'send_date' => $this->send_date,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course' => new CourseResource($this->whenLoaded('course')),
            'guardians' => GuardianResource::collection($this->whenLoaded('guardians')),
            'guardians_count' => $this->when(
                $this->guardians_count !== null, 
                $this->guardians_count
            ),
        ];
    }
}
