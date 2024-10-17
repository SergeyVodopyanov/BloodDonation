<?php
namespace App\Http\Controllers\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BloodDonationStation;
use App\Http\Resources\BloodDonationStationResource;

class ShowController extends Controller
{
    public function __invoke($id){
        $bloodDonationStation = BloodDonationStation::with(['city', 'bloodGroups', 'donationSessions'])->findOrFail($id);
        return BloodDonationStationResource::make($bloodDonationStation);


    }
}