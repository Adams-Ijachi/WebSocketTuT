<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Driver;
use App\Http\Requests\DriverLoginRequest;

use Illuminate\Support\Facades\Hash;

use App\Http\Resources\DriverResource;



class AuthController extends Controller
{

    public function login(DriverLoginRequest $request)
    {

        try {

            $credentials = $request->safe()->only(['email','password']);

            $driver = Driver::where('email',$credentials['email'])->first();

            if (!Hash::check($credentials['password'], $driver->password)) {
                return response()->json(['message'=>"Password Mismatch"],400);
            }
           
            $token = $driver->createToken('driverToken')->plainTextToken;

            return  (new DriverResource($driver))->additional([
                'token' => $token,
                'message' => 'logged in successfully',
            ]);
           
        } catch (\Throwable $e) {

            return response()->json(['message'=>$e->getMessage() ],400);

        }
      
    }
}
