<?php

namespace App\Http\Controllers;

use Ably\AblyRest;
use Modules\Core\Entities\User;
use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestEventController extends Controller
{
    public function trigger()
    {
        $user = User::first();
        broadcast(new UserLoggedIn($user))->toOthers();

        $user = Auth::user();
        $user->update(['active' => 1]);

        // 2️⃣ إرسال event عبر Ably
        $ably = new AblyRest(env('ABLY_API_KEY')); // ضيف Ably API key في .env
        $ably->channel('dashboard-updates')->publish('user.logged-in', [
            'id' => $user->id,
            'name' => $user->name,
        ]);

        return 'Event triggered successfully';
    }
}
