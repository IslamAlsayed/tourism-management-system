<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.activity-log.index');
    }
}