<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'enrollment_date' => $this->enrollment_date,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'student' => new StudentResource($this->whenLoaded('student')),
            'course' => new CourseResource($this->whenLoaded('course')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'total_paid' => $this->when(
                $this->payments_sum_amount !== null,
                $this->payments_sum_amount
            ),
        ];
    }
}
