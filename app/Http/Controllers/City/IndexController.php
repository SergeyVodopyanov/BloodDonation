<?php
namespace App\Http\Controllers\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Resources\CityResource;
class IndexController extends Controller
{
    public function __invoke(){
        $cities = City::all();
        return CityResource::collection($cities);
    }
}