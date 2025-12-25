<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timezone\StoreRequest;
use App\Http\Requests\Timezone\UpdateRequest;

class TimezoneController extends Controller
{

    public function index()
    {
        return 'index';
    }
    public function create()
    {
        return 'create';
    }
    public function store(StoreRequest $request)
    {
        return 'store';
    }
    public function show($id)
    {
        return 'show';
    }
    public function edit($id)
    {
        return 'edit';
    }
    public function update(UpdateRequest $request, $id)
    {
        return 'update';
    }
    public function destroy($id)
    {
        return 'destroy';
    }
}