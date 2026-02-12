<?php

namespace App\Http\Controllers\Api;

use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Nationality;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function getCities()
    {
        $search = request()->input('q', '');
        $page = request()->input('page', 1);
        $perPage = 50;
        $query = City::query()->select('id', 'name')->orderBy('name');
        if (!empty($search))
            $query->where('name', 'like', "%{$search}%");
        $total = $query->count();
        $cities = $query->skip(($page - 1) * $perPage)->take($perPage)->get()
            ->map(fn($city) => ['id' => $city->id, 'text' => $city->name]);
        return response()->json(['results' => $cities, 'pagination' => ['more' => ($page * $perPage) < $total]]);
    }

    public function getCityById($id)
    {
        $city = City::select('id', 'name')->find($id);
        if (!$city)
            return response()->json(null, 404);
        return response()->json(['id' => $city->id, 'text' => $city->name]);
    }

    public function getNationalities()
    {
        $search = request()->input('q', '');
        $page = request()->input('page', 1);
        $perPage = 50;
        $query = Nationality::query()->select('id', 'name')->orderBy('name');
        if (!empty($search))
            $query->where('name', 'like', "%{$search}%");
        $total = $query->count();
        $cities = $query->skip(($page - 1) * $perPage)->take($perPage)->get()
            ->map(fn($n) => ['id' => $n->id, 'text' => $n->name]);
        return response()->json(['results' => $cities, 'pagination' => ['more' => ($page * $perPage) < $total]]);
    }

    public function getNationalityById($id)
    {
        $nationality = Nationality::select('id', 'name')->find($id);
        if (!$nationality)
            return response()->json(null, 404);
        return response()->json(['id' => $nationality->id, 'text' => $nationality->name]);
    }
}
