<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request){
        $data = $request->validated();
        // dump($data);
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $data['email'])->first();
        if($user){
            return response([
                'error' => 'Email already exists'
            ], 403);
        }
        $user = User::Create($data);
        // $token = auth()->tokenById($user->id);
        $token = JWTAuth::fromUser($user);
        
        return response(['access_token' => $token]);
    }
}