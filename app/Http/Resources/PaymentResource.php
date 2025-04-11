<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'method' => [
                'value' => $this->method->value,
                'label' => $this->method->label(),
            ],
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'payment_date' => $this->payment_date,
            'reference_number' => $this->reference_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'enrollment' => new EnrollmentResource($this->whenLoaded('enrollment')),
        ];
    }
}
