<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;
    protected $table = 'points';

    protected $fillable = [
        'title',
        'city',
        'address',
        'geolocation',
        'first_blood_group_count',
        'second_blood_group_count',
        'third_blood_group_count',
        'fourth_blood_group_count',
        'enough_count'
    ];
     
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
