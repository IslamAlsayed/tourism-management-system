<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => \Modules\Core\Entities\User::all(), 'message' => 'User index']);
    }
}
