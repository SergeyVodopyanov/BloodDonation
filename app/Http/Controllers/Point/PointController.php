<?php

namespace App\Http\Controllers\Point;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Http\Resources\Point\PointResource;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Resources\User\UserResource;


class PointController extends Controller
{

    public function index(){
        $points = Point::all();
        // $points = Point::with('donations.user', 'donations.point')->get();
        return PointResource::collection($points);
    }

    public function show($id){
        // $point = Point::with('donations.user', 'donations.point')->find($id);
        $point = Point::find($id);
        return new PointResource($point);
    }

    public function getAvailableTimes($id, Request $request){
        $point = Point::find($id);
        $selectedDate = Carbon::parse($request->input('date'));
        $takenTimes = $point->donations()
            ->whereDate('date', $selectedDate)
            ->pluck('time')
            ->toArray();
        return response()->json($takenTimes);

    }
}
