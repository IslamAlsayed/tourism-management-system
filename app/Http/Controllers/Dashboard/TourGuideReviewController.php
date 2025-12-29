<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TourGuide;
use App\Models\TourGuideReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideReview\StoreRequest;
use App\Http\Requests\TourGuideReview\UpdateRequest;

class TourGuideReviewController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.tour-guides-reviews.index');
    }

    public function create()
    {
        $tourGuides = TourGuide::all();
        return view('pages.dashboard.tour-guides-reviews.create', compact('tourGuides'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $tourGuideReview = TourGuideReview::create($validated);
        if ($tourGuideReview) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.tour-guides-review')]));
            }
            return redirect()->route('tour-guides-reviews.index')->withSuccess(__('messages.type_created', ['type' => __('main.tour-guides-review')]));
        }
        return redirect()->route('tour-guides-reviews.index')->withError(__('messages.type_creation_failed', ['type' => __('main.tour-guides-review')]));
    }

    public function show($id)
    {
        $tourGuideReview = TourGuideReview::with(['tour_guide'])->find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        return view('pages.dashboard.tour-guides-reviews.show', compact('tourGuideReview'));
    }

    public function edit($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $tourGuides = TourGuide::all();
        return view('pages.dashboard.tour-guides-reviews.edit', compact('tourGuides', 'tourGuideReview'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $validated = $request->validated();
        $updated = $tourGuideReview->update($validated);
        if ($updated) {
            return redirect()->route('tour-guides-reviews.index')->withSuccess(__('messages.type_updated', ['type' => __('main.tour-guides-review')]));
        }
        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.tour-guides-review')]));
    }

    public function destroy($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $deleted = $tourGuideReview->delete();
        return $deleted
            ? redirect()->route('tour-guides-reviews.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.tour-guide-review')]))
            : redirect()->route('tour-guides-reviews.index')->withError(__('messages.type_deletion_failed', ['type' => __('main.tour-guide-review')]));
    }
}