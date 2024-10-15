<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['bloodGroupTitle'];

    use HasFactory;

    protected $table = 'cities';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bloodDonationStations()
    {
        return $this->hasMany(BloodDonationStation::class);
    }
}
