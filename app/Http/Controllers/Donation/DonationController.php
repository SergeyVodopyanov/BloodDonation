<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Http\Requests\Donation\StoreRequest;


class DonationController extends Controller
{

    public function store(StoreRequest $request){
        
        $data = $request->validated();
        // $data['date'] = '2024-12-10';
        // $data['time'] = '12:00:00';

        $donation = Donation::Create($data);

        return response()->json(['message' => 'Запись успешно создана', 'donation' => $donation], 201);
    }
}
