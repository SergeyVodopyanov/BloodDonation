<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodDonationStationResource extends JsonResource
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
            'bloodDonationStationTitle' => $this->bloodDonationStationTitle,
            'bloodDonationStationAddress' => $this->bloodDonationStationAddress,
            'bloodDonationStationGeolocation' => $this->bloodDonationStationGeolocation,
            'city' => new CityResource($this->city),
            'bloodGroups' => BloodGroupResource::collection($this->bloodGroups),
        ];
    }
}
