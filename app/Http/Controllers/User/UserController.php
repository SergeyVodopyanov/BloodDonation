<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;

class UserController extends Controller
{
    public function getUserDonations($user_id){
        $donations = Donation::with('point')->where('user_id', $user_id)->get();
        return response()->json($donations);
    }

    public function getLastDonation($user_id){
        $donation = Donation::where('user_id', $user_id)->latest()->first();
        return response()->json($donation);
    }
}
