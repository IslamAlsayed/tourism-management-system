<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // بيانات ثابتة مؤقتة بدلاً من قاعدة البيانات
        $stats = [
            'countries' => 245,
            'cities' => 88092,
            'currencies' => 49,
            'users' => 10,
        ];

        return view('pages.admin.index', compact('stats'));
    }
}