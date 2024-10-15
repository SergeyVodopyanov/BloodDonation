<?php
namespace App\Http\Controllers\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BloodDonationStation;
use App\Http\Resources\BloodDonationStationResource;

class IndexController extends Controller
{
    public function __invoke(){
        $bloodDonationStations = BloodDonationStation::with(['city', 'bloodGroups'])->get();
        // $bloodDonationStations = BloodDonationStation::with('city')->get();
        // $bloodDonationStations = BloodDonationStation::with('bloodGroups')->get();
        return BloodDonationStationResource::collection($bloodDonationStations);


    }
}