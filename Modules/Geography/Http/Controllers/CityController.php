<?php

namespace Modules\Geography\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Geography\Entities\City;
use Modules\Geography\Http\Requests\City\StoreRequest;
use Modules\Geography\Http\Requests\City\UpdateRequest;

class CityController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('geography::cities.index');
    }

    public function create()
    {
        return view('geography::cities.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $city = City::create($validated);
        if (!$city)
            return redirect()->route('dashboard.geography.cities.index')->withError(__('messages.type_creation_failed', ['type' => __('main.city')]));
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $city, 'photo', 'cities');
        }
        return $city
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.city')]))
                : redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_created', ['type' => __('main.city')])))
            : redirect()->back()->withError(__('messages.type_creation_failed', ['type' => __('main.city')]));
    }

    public function show($id)
    {
        $city = City::with((new City)->getRelationshipNames())->find($id);
        return $city
            ? view('geography::cities.show', compact('city'))
            : redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
    }

    public function edit($id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        return view('geography::cities.edit', compact('city'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        $validated = $request->validated();
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $city, 'photo', 'cities');
        }
        $updated = $city->update($validated);
        return $updated
            ? redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_updated', ['type' => __('main.city')]))
            : redirect()->route('dashboard.geography.cities.index')->withError(__('messages.type_update_failed', ['type' => __('main.city')]));
    }

    public function destroy($id)
    {
        $city = City::find($id);
        if (!$city)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.city')]));
        $deleted = $city->delete();
        return $deleted
            ? redirect()->route('dashboard.geography.cities.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.city')]))
            : redirect()->route('dashboard.geography.cities.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.city')]));
    }
}
