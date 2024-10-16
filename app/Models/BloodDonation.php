<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonation extends Model
{
    use HasFactory;

    protected $table = 'blood_donations';

    protected $fillable = [
        'userId',
        'donationSessionId'
    ];
}
