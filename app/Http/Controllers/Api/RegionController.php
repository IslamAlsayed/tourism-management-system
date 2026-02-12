<?php

namespace App\Http\Controllers\Api;

use Modules\Geography\Entities\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::query();
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('name_ar') && $request->name_ar) {
            $query->where('name_ar', 'like', '%' . $request->name_ar . '%');
        }
        $regions = $query->get();
        return response()->json(['status' => 'success', 'data' => $regions, 'message' => 'All Regions'], 200);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Region::class);
        $request->validate([
            'name' => [new \App\Rules\EmailRequired, 'string', 'unique:regions,name'],
            'name_ar' => [new \App\Rules\EmailRequired, 'string'],
        ]);
        $region = Region::create($request->only('name', 'name_ar'));
        return response()->json(['status' => 'success', 'data' => $region, 'message' => 'Region created successfully'], 201);
    }

    public function update(Request $request, Region $region)
    {
        $this->authorize('update', $region);
        $request->validate([
            'name' => [new \App\Rules\EmailRequired, 'string', 'unique:regions,name,' . $region->id],
            'name_ar' => ['nullable', 'string'],
        ]);
        $region->update($request->only('name', 'name_ar'));
        return response()->json(['status' => 'success', 'data' => $region, 'message' => 'Region updated successfully'], 200);
    }

    public function destroy(Region $region)
    {
        $this->authorize('delete', $region);
        $region->delete();
        return response()->json(['status' => 'success', 'data' => null, 'message' => 'Region deleted successfully'], 200);
    }
}
