<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonationStationBloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_donation_stations_blood_groups';

    protected $fillable = [
        'bloodDonationStationId',
        'BloodGroupId',
        'bloodInStationEnough'
    ];

    public function bloodGroup()
    {
        return $this->belongsTo(bloodGroup::class, 'bloodGroupId');
    }

}
