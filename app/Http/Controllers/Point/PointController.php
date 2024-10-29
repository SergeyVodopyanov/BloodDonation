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
use App\Services\PointService;

class PointController extends Controller
{
    
    public $service;

    public function __construct(PointService $service){
        $this->service = $service;
    }

    public function index(){
        $points = $this->service->index();
        return PointResource::collection($points);
    }

    public function show($id){
        $point = $this->service->show($id); 
        return new PointResource($point);
    }

    public function getAvailableTimes($id, Request $request){
        $selectedDate = Carbon::parse($request->input('date'));
        $takenTimes = $this->service->getAvailableTimes($id, $selectedDate);
        return response()->json($takenTimes);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls',]);
        $this->service->import($request);
        return response()->json([], 200);
    }
}
