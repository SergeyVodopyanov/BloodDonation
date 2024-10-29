<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\HonoraryDonorsResource;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\User;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Carbon;
use App\Services\UserService;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\Donation\DonationResource;

class UserController extends Controller
{
    public $service;

    public function __construct(UserService $service){
        $this->service = $service;
    }

    public function getUserDonations($user_id){
        $donations = $this->service->getUserDonations($user_id);
        return DonationResource::collection($donations);
    }

    public function getLastDonation($user_id){
        $donation = $this->service->getLastDonation($user_id);
        return new DonationResource($donation);
    }

    public function getHonoraryDonors(){
        $donors = $this->service->getHonoraryDonors();
        return HonoraryDonorsResource::collection($donors);
    }

    public function store(StoreRequest $request){
        $data = $request->validated();
        $token = $this->service->store($data);
        return response(['access_token' => $token]);
    }
}
