<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {

        try {

            $credentials = $request->safe()->only(['email','password']);

            $user = User::where('email',$credentials['email'])->first();

            // if (!Hash::check($credentials['password'], $user->password)) {
            //     return response()->json(['message'=>"Password Mismatch"],400);
            // }
           
            $token = $user->createToken('userToken')->plainTextToken;

            return  (new UserResource($user))->additional([
                'token' => $token,
                'message' => 'logged in successfully',
            ]);
           
        } catch (\Throwable $e) {

            return response()->json(['message'=>$e->getMessage() ],400);

        }
      
    }
}
