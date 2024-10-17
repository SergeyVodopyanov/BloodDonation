<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BloodGroup\BloodGroupWithEnoughResource;
use App\Http\Resources\DonationSession\DonationSessionResource;


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
            'bloodDonationStationLatitude' => $this->bloodDonationStationLatitude,
            'bloodDonationStationAddress' => $this->bloodDonationStationAddress,
            'bloodDonationStationLongitude' => $this->bloodDonationStationLongitude,
            'city' => new CityResource($this->city),
            'bloodGroups' => BloodGroupWithEnoughResource::collection($this->bloodGroups),
            'donationSessions' => DonationSessionResource::collection($this->donationSessions)
        ];
    }
}
