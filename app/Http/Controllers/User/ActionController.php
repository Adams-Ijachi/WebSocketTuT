<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Driver,
    Request as RequestModel
};
use App\Http\Requests\StoreRequestRequest;
use Illuminate\Support\Facades\Auth;

use App\Events\DriverRequested;
use App\Http\Resources\DriverResource;




class ActionController extends Controller
{
    public function createRequest( Driver $driver)
    {

        // $request_data = $request->validated();
        $request_data['user_id'] = Auth::id();
        $request_data['driver_id'] = $driver->id;
        $request = RequestModel::firstOrCreate(
            $request_data
        );
       

        DriverRequested::dispatch($request);

        return response()->json([
            'message' => "Request Sent to Driver",
        ]);
    }


    public function getDrivers()
    {
        return DriverResource::collection(Driver::all());
    }
}
