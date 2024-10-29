<?php

namespace App\Services;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Point;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PointsImport;

class PointService{
    
    public function index(){
        return Point::all();
    }

    public function show($id){
        return Point::find($id);
    }

    public function getAvailableTimes($id, $selectedDate){
        $point = Point::find($id);
        return $point->donations()->whereDate('date', $selectedDate)->pluck('time')->toArray();
    }

    public function import(Request $request){
        Excel::import(new PointsImport, $request->file('file'));
    }
    
}