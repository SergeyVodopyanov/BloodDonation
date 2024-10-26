<?php

namespace App\Http\Controllers\Point;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Http\Resources\Point\PointResource;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Resources\User\UserResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PointsImport;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PointsImport, $request->file('file'));

        return response()->json(['message' => 'Данные успешно импортированы']);
    }
}
