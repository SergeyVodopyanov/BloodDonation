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
        'bloodDonationStationGeolocation',
        'cityId'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function bloodGroups()
    {
        return $this->belongsToMany(BloodGroup::class, 'blood_donation_station_blood_group')->withPivot('enough')->withTimestamps();
    }
}
