<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Activity log channel - accessible by all authenticated users
Broadcast::channel('activities', function ($user) {
    // return $user != null && $user->can('view activities');
    return $user !== null;
});

// Import/Export channel - per user
Broadcast::channel('import-channel-{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});