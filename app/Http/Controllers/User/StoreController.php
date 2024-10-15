<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class StoreController extends Controller
{
    public function __invoke(StoreRequest $request){
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $data['email'])->first();
        if($user){
            return response([
                'error' => 'Email already exists'
            ], 403);
        }
        $user = User::Create($data);
        $token = auth()->tokenById($user->id);
        return response(['access_token' => $token]);
    }
}