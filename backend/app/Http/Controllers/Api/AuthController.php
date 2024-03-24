<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'status'=>false,
                'message'=>['email or password wrong!'],
                'data'=>null
            ],404);
        }
        
        $user->token = Str::uuid()->toString();
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success'    => true,
            'message'=>['logout successfully!'],
            'data'=>null
        ], 200);
    }
}
