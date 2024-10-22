<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function store(Request $request){
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'point_id' => 'required|exists:points,id',
        // ]);
        // $data = $request->validated();

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'point_id' => 'required|exists:points,id',
        ]);

        $data['date'] = '2024-12-10';
        $data['time'] = '12:00:00';

        $donation = Donation::Create($data);

        return response()->json(['message' => 'Запись успешно создана', 'donation' => $donation], 201);
    }
}
