<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\HonoraryDonorsResource;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\User;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Carbon;

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

    public function getHonoraryDonors(){
        // $donors = User::whereNotNull('honorary_donor')->where('honorary_donor', '<', Carbon::now())->withCount('donations')->get();
        $donors = User::where('honorary_donor', '<', Carbon::now())->withCount('donations')->get();
        return HonoraryDonorsResource::collection($donors);
    }
}
