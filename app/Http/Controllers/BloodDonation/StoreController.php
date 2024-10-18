<?php

namespace App\Http\Controllers\BloodDonation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BloodDonation\StoreRequest;
    
use App\Models\DonationSession;
use App\Models\BloodDonation;


class StoreController extends Controller
{
    public function __invoke(StoreRequest $request){
        $data = $request->validated();

        $donationSession = DonationSession::find($data['donationSessionId']);
        if (!$donationSession) {
            return response()->json(['error' => 'Donation session not found'], 404);
        }
        $donationSession->isBusy = true;
        $donationSession->save();

        $bloodDonation = BloodDonation::create([
            'donationSessionId' => $data['donationSessionId'],
            'UserId' => $data['userId'],
        ]);

        return response()->json([
            'message' => 'Blood donation created successfully',
            'data' => $bloodDonation,
        ], 201);

    }
}
