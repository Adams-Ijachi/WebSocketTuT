<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Driver;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('User.{id}', function ($user, $id) {
    
    return (int) $user->id === (int) $id;
},['guards' => ['users']]);


Broadcast::channel('driver.{driverId}', function ($user, $driverId) {
    return $user->id === Driver::findOrNew($driverId)->id;
},['guards' => ['drivers']]);