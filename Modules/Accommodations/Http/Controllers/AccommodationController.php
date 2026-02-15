<?php

namespace Modules\Accommodations\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Geography\Entities\City;
use Modules\Accommodations\Entities\Type;
use Modules\Accommodations\Contracts\AccommodationServiceInterface;
use Modules\Accommodations\Http\Requests\Accommodations\StoreRequest;
use Modules\Accommodations\Http\Requests\Accommodations\UpdateRequest;

class AccommodationController extends Controller
{
    use PhotoUploadTrait;

    protected $accommodationService;

    public function __construct(AccommodationServiceInterface $accommodationService)
    {
        $this->accommodationService = $accommodationService;
    }

    public function index()
    {
        return view('accommodations::accommodations.index');
    }

    public function create()
    {
        $types = Type::orderBy('name')->get();
        $countCities = City::count();
        return view('accommodations::accommodations.create', compact('types', 'countCities'));
    }

    public function store(StoreRequest $request)
    {
        // Create accommodation with all related data via service
        $accommodation = $this->accommodationService->createAccommodation($request->validated());
        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $accommodation, 'photo', 'accommodations');
        }
        return $request->has('save_and_add')
            ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.accommodation')]))
            : redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_created', ['type' => __('main.accommodation')]));
    }

    public function show($id)
    {
        $accommodation = $this->accommodationService->getAccommodationById($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        return view('accommodations::accommodations.show', compact('accommodation'));
    }

    public function edit($id)
    {
        $accommodation = $this->accommodationService->getAccommodationById($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        $types = Type::orderBy('name')->get();
        $countCities = City::count();
        return view('accommodations::accommodations.edit', compact('accommodation', 'types', 'countCities'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $accommodation = $this->accommodationService->getAccommodationById($id);
        if (!$accommodation)
            return redirect()->route('dashboard.accommodations.index')->withError(__('messages.type_not_found', ['type' => __('main.accommodation')]));
        // Update accommodation with all related data via service
        $updated = $this->accommodationService->updateAccommodation($id, $request->validated());
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $accommodation, 'photo', 'accommodations');
        }
        return $updated
            ? redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_updated', ['type' => __('main.accommodation')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.accommodation')]));
    }

    public function destroy($id)
    {
        $deleted = $this->accommodationService->deleteAccommodation($id);

        if (!$deleted) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.accommodation')]));
        }

        return redirect()->route('dashboard.accommodations.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.accommodation')]));
    }
}