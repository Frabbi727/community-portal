<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OccasionBanner;
use App\Models\SliderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    public function sliderCreatePage(): View
    {
        return view('admin.media-slider-create');
    }

    public function sliderListPage(): View
    {
        return view('admin.media-slider-list', [
            'sliderItems' => SliderItem::query()->with('user')->latest('created_at')->get(),
        ]);
    }

    public function bannerCreatePage(): View
    {
        return view('admin.media-banner-create');
    }

    public function bannerListPage(): View
    {
        return view('admin.media-banner-list', [
            'banners' => OccasionBanner::query()->with('user')->latest('created_at')->get(),
        ]);
    }

    public function storeSliderItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'activity_note' => ['nullable', 'string', 'max:3000'],
            'activity_date' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['required', 'image', 'max:6144'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $request->file('image')->store('slider-items', 'public');

        SliderItem::query()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'activity_note' => $validated['activity_note'] ?? null,
            'activity_date' => $validated['activity_date'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'image_path' => $imagePath,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', 'Slider image uploaded successfully.');
    }

    public function replaceSliderImage(Request $request, SliderItem $sliderItem): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:6144'],
        ]);

        Storage::disk('public')->delete($sliderItem->image_path);
        $imagePath = $validated['image']->store('slider-items', 'public');

        $sliderItem->update(['image_path' => $imagePath]);

        return back()->with('success', 'Slider image changed successfully.');
    }

    public function toggleSliderItem(SliderItem $sliderItem): RedirectResponse
    {
        $sliderItem->update(['is_active' => ! $sliderItem->is_active]);

        return back()->with('success', 'Slider image status updated.');
    }

    public function storeBanner(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:celebration,mourning,occasion'],
            'message' => ['nullable', 'string', 'max:3000'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'image' => ['nullable', 'image', 'max:6144'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('occasion-banners', 'public')
            : null;

        OccasionBanner::query()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'message' => $validated['message'] ?? null,
            'starts_on' => $validated['starts_on'] ?? null,
            'ends_on' => $validated['ends_on'] ?? null,
            'image_path' => $imagePath,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', 'Occasion banner created successfully.');
    }

    public function replaceBannerImage(Request $request, OccasionBanner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:6144'],
        ]);

        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $path = $validated['image']->store('occasion-banners', 'public');
        $banner->update(['image_path' => $path]);

        return back()->with('success', 'Occasion banner photo updated.');
    }

    public function toggleBanner(OccasionBanner $banner): RedirectResponse
    {
        $banner->update(['is_active' => ! $banner->is_active]);

        return back()->with('success', 'Banner status updated.');
    }

    public function destroySliderItem(SliderItem $sliderItem): RedirectResponse
    {
        Storage::disk('public')->delete($sliderItem->image_path);
        $sliderItem->delete();

        return back()->with('success', 'Slider image removed.');
    }

    public function destroyBanner(OccasionBanner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return back()->with('success', 'Banner removed.');
    }
}
