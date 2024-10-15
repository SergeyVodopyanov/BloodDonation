<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donationSession extends Model
{
    use HasFactory;

    protected $table = 'donation_sessions';

    protected $fillable = [
        'donationSessionDate',
        'donationSessionStartTime',
        'donationSessionEndTime',
        'bloodDonationStationId',
    ];

    public function bloodDonationPoint()
    {
        return $this->belongsTo(BloodDonationStation::class);
    }
}

