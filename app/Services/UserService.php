<?php

namespace App\Services;

use App\Models\User;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{

    public function getUserDonations($user_id)
    {
        return Donation::with('point')->where('user_id', $user_id)->get();
    }

    public function getLastDonation($user_id)
    {
        return Donation::where('user_id', $user_id)->orderBy('date', 'desc')->orderBy('time', 'desc')->first();
    }

    public function getHonoraryDonors()
    {
        return User::where('honorary_donor', '<', Carbon::now())->withCount('donations')->get();
    }

    public function store($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            return response([
                'error' => 'Email already exists'
            ], 403);
        }
        // $user = User::Create($data);
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'passport_series' => $data['passport_series'],
            'passport_number' => $data['passport_number'],
            'city' => $data['city'],
            'blood_group' => $data['blood_group'],
            'image_url' => $data['image_url'] ?? null, // Убедитесь, что image_url передается
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
