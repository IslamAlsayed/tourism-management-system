<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TourGuide;
use App\Models\TourGuideReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourGuideReview\TourGuideReviewCreateRequest;
use App\Http\Requests\TourGuideReview\TourGuideReviewUpdateRequest;

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

    public function store(TourGuideReviewCreateRequest $request)
    {
        $validated = $request->validated();
        $tourGuideReview = TourGuideReview::create($validated);
        if ($tourGuideReview) {
            if ($request->has('save_and_add')) {
                return redirect()->back()->with('success', __('main.messages.type_created', ['type' => __('main.tour-guides-review')]));
            }
            return redirect()->route('tour-guides-reviews.index')->with('success', __('main.messages.type_created', ['type' => __('main.tour-guides-review')]));
        }
        return redirect()->route('tour-guides-reviews.index')->with('error', __('main.messages.type_creation_failed', ['type' => __('main.tour-guides-review')]));
    }

    public function edit($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $tourGuides = TourGuide::all();
        return view('pages.dashboard.tour-guides-reviews.edit', compact('tourGuides', 'tourGuideReview'));
    }

    public function update(TourGuideReviewUpdateRequest $request, $id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $validated = $request->validated();
        $updated = $tourGuideReview->update($validated);
        if ($updated) {
            return redirect()->route('tour-guides-reviews.index')->with('success', __('main.messages.type_updated', ['type' => __('main.tour-guides-review')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.tour-guides-review')]));
    }

    public function destroy($id)
    {
        $tourGuideReview = TourGuideReview::find($id);
        if (!$tourGuideReview) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.tour-guide-review')]));
        }
        $deleted = $tourGuideReview->delete();
        if ($deleted) {
            return redirect()->back()->with('success', __('main.messages.type_deleted', ['type' => __('main.tour-guides-review')]));
        }
        return redirect()->back()->with('error', __('main.messages.type_deletion_failed', ['type' => __('main.tour-guides-review')]));
    }
}