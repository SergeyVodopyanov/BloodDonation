<?php

namespace App\Http\Resources\BloodGroup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodGroupResource extends JsonResource
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
            'bloodGroupTitle' => $this->bloodGroupTitle,
        ];
    }
}
