<?php

namespace App\Services;

use App\Models\Donation;

class DonationService{
    public function store($data){
        Donation::create($data);
    }
}