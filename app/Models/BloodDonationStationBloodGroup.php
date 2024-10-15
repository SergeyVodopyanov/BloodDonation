<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonationStationBloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_donations_station_blood_groups';

    protected $fillable = [
        'bloodDonationStationId',
        'BloodGroupId',
        'bloodInStationEnough'
    ];
}
