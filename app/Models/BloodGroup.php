<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_groups';

    protected $fillable = ['bloodGroupTitle'];

    // Определяем связь "один ко многим" с моделью User
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bloodDonationStations()
    {
        return $this->belongsToMany(BloodDonationStation::class, 'blood_donation_stations_blood_groups', 'bloodGroupId', 'bloodDonationStationId')->withPivot('bloodInStationEnough');;
    }
}
