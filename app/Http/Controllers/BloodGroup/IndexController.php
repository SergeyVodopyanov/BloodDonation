<?php
namespace App\Http\Controllers\BloodGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BloodGroup;
use App\Http\Resources\BloodGroupResource;
class IndexController extends Controller
{
    public function __invoke(){
        $bloodGroups = BloodGroup::all();
        return BloodGroupResource::collection($bloodGroups);
    }
}