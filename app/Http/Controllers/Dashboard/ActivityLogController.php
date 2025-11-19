<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    /**
     * Display the activity stream dashboard.
     */
    public function index()
    {
        return view('pages.dashboard.activity-log.index');
    }
}