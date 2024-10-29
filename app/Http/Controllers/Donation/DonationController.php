<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Http\Requests\Donation\StoreRequest;
use App\Services\DonationService;

class DonationController extends Controller
{

    public $service;

    public function __construct(DonationService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request){
        $data = $request->validated();
        $this->service->store($data);
        return response()->json([], 200);
    }
}
