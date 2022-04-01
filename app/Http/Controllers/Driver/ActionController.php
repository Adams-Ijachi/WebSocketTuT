<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{

    Request as RequestModel
};
use App\Events\UserRequestStatusUpdate;

use App\Events\DriverRequested;


class ActionController extends Controller
{
    public function requestAction(Request $request, RequestModel $model)
    {
        
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $model->update([
            'status' => $request->status
        ]);

        UserRequestStatusUpdate::dispatch($model);

        return response()->json([
            'message' => 'Request Status updated'
        ]);
    }
}
