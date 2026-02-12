<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CommunityPost;
use App\Models\Member;
use App\Models\Notice;
use App\Models\OccasionBanner;
use App\Models\SliderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MemberAreaController extends Controller
{
    public function index(): View
    {
        $publicNotices = Notice::query()
            ->published()
            ->where('is_public', true)
            ->latest('published_at')
            ->limit(8)
            ->get();

        $publicCampaigns = Campaign::query()
            ->where('is_public', true)
            ->latest('created_at')
            ->limit(8)
            ->get();

        $communityPosts = CommunityPost::query()
            ->with('user')
            ->where('is_public', true)
            ->latest('created_at')
            ->limit(12)
            ->get();

        $newMembers = Member::query()
            ->where('is_active', true)
            ->where('is_public', true)
            ->latest('joined_on')
            ->limit(8)
            ->get();

        $activities = $this->buildActivities($publicNotices, $publicCampaigns, $communityPosts);

        return view('member.dashboard', [
            'privateNotices' => $publicNotices,
            'privateCampaigns' => $publicCampaigns,
            'communityPosts' => $communityPosts,
            'newMembers' => $newMembers,
            'activities' => $activities,
            'occasionBanners' => OccasionBanner::query()->currentlyVisible()->latest('created_at')->limit(3)->get(),
            'communityAbout' => 'Our community portal is now public. Anyone can follow community activities, events, celebrations, memorial updates, and official notices uploaded by admin.',
        ]);
    }

    private function buildActivities(Collection $notices, Collection $campaigns, Collection $posts): Collection
    {
        return collect()
            ->merge($notices->map(fn (Notice $notice) => [
                'type' => 'Notice',
                'title' => $notice->title,
                'time' => $notice->published_at,
            ]))
            ->merge($campaigns->map(fn (Campaign $campaign) => [
                'type' => 'Campaign',
                'title' => $campaign->title,
                'time' => $campaign->created_at,
            ]))
            ->merge($posts->map(fn (CommunityPost $post) => [
                'type' => 'Post',
                'title' => $post->title,
                'time' => $post->created_at,
            ]))
            ->sortByDesc('time')
            ->take(12)
            ->values();
    }

    public function sliderImages(): JsonResponse
    {
        $items = SliderItem::query()
            ->with('user:id,name')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('created_at')
            ->limit(30)
            ->get()
            ->map(fn (SliderItem $item) => [
                'title' => $item->title,
                'body' => $item->activity_note,
                'author' => $item->user?->name ?? 'Admin',
                'activity_date' => $item->activity_date?->toDateString(),
                'image_url' => $item->image_url,
            ])
            ->values();

        return response()->json([
            'images' => $items,
            'count' => $items->count(),
        ]);
    }
}
