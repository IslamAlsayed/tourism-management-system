<?php

namespace Modules\TourGuides\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\TourGuides\Entities\TourGuide;
use Modules\TourGuides\Entities\TourGuideReview;
use Modules\TourGuides\Http\Requests\TourGuideReview\StoreRequest;
use Modules\TourGuides\Http\Requests\TourGuideReview\UpdateRequest;

class GuideReviewController extends Controller
{
    public function index()
    {
        return view('tourguides::guides-reviews.index');
    }

    public function create()
    {
        $tourGuides = TourGuide::all();
        return view('tourguides::guides-reviews.create', compact('tourGuides'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $created = TourGuideReview::create($validated);
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->with('success', __('messages.type_created', ['type' => __('main.tours.guide-review')]))
                : redirect()->route('dashboard.tourguides.guides-reviews.index')->with('success', __('messages.type_created', ['type' => __('main.tours.guide-review')])))
            : redirect()->route('dashboard.tourguides.guides-reviews.index')->with('error', __('messages.type_creation_failed', ['type' => __('main.tours.guide-review')]));
    }

    public function show($id)
    {
        $tourGuideReview = TourGuideReview::with((new TourGuideReview)->getRelationshipNames())->find($id);
        if (!$tourGuideReview)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-review')]));
        return view('tourguides::guides-reviews.show', compact('tourGuideReview'));
    }

    public function edit($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-review')]));
        $tourGuides = TourGuide::all();
        return view('tourguides::guides-reviews.edit', compact('tourGuides', 'tourGuideReview'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-review')]));
        $validated = $request->validated();
        $updated = $tourGuideReview->update($validated);
        return $updated
            ? redirect()->route('dashboard.tourguides.guides-reviews.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tours.guides-review')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tours.guides-review')]));
    }

    public function destroy($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tours.guide-review')]));
        $deleted = $tourGuideReview->delete();
        return $deleted
            ? redirect()->route('dashboard.tourguides.guides-reviews.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tours.guide-review')]))
            : redirect()->route('dashboard.tourguides.guides-reviews.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tours.guide-review')]));
    }
}
