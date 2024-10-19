<?php

namespace App\Http\Resources\Point;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Donation\DonationResource;


class PointResource extends JsonResource
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
            'city' => $this->city,
            'address' => $this->address,
            'geolocation' => $this->geolocation,
            'first_blood_group_count' => $this->first_blood_group_count,
            'second_blood_group_count' => $this->second_blood_group_count,
            'third_blood_group_count' => $this->third_blood_group_count,
            'fourth_blood_group_count' => $this->fourth_blood_group_count,
            'enough_count' => $this->enough_count,
            // 'donations' => DonationResource::collection($this->donations),
        ];
    }
}
