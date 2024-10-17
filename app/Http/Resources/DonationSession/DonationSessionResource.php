<?php

namespace App\Http\Resources\DonationSession;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationSessionResource extends JsonResource
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
            'donationSessionDate' => $this->donationSessionDate,
            'donationSessionStartTime' => $this->donationSessionStartTime,
            'donationSessionEndTime' => $this->donationSessionEndTime,
        ];
    }
}
