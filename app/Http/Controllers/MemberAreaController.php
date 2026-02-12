<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Member;
use App\Models\Notice;
use Illuminate\View\View;

class MemberAreaController extends Controller
{
    public function index(): View
    {
        return view('member.dashboard', [
            'privateNotices' => Notice::query()
                ->published()
                ->where('is_public', false)
                ->latest('published_at')
                ->limit(5)
                ->get(),
            'privateCampaigns' => Campaign::query()
                ->where('is_public', false)
                ->latest('created_at')
                ->limit(5)
                ->get(),
            'members' => Member::query()->where('is_active', true)->latest('joined_on')->limit(8)->get(),
        ]);
    }
}
