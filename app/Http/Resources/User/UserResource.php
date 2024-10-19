<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Donation\DonationResource;


class UserResource extends JsonResource
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
            'email' => $this->email,
            'password' => $this->password,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'blood_group' => $this->blood_group,
            'city' => $this->city,
            // 'donations' => DonationResource::collection($this->donations),
            
        ];
    }
}
