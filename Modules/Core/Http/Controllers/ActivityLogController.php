<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('core::activities.index');
    }

    public function users()
    {
        return view('core::activities.users');
    }

    public function system()
    {
        return view('core::activities.system');
    }
}
