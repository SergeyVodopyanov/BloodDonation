<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bloodDonationStation extends Model
{
    use HasFactory;

    protected $table = 'blood_donation_stations';

    protected $fillable = [
        'bloodDonationStationAddress',
        'bloodDonationStationLatitude',
        'bloodDonationStationLongitude',
        'cityId'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId');
    }


    public function bloodGroups()
    {
        return $this->belongsToMany(BloodGroup::class, 'blood_donation_stations_blood_groups', 'bloodDonationStationId', 'bloodGroupId')->withPivot('bloodInStationEnough');;
    }
}
