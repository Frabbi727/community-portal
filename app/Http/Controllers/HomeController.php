<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Member;
use App\Models\Notice;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'membersCount' => Member::visible()->count(),
            'activeCampaignsCount' => Campaign::query()->where('status', 'active')->where('is_public', true)->count(),
            'latestNotices' => Notice::query()
                ->published()
                ->where('is_public', true)
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'latestCampaigns' => Campaign::query()
                ->visible()
                ->latest('created_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
