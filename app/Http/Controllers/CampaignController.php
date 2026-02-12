<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        return view('pages.campaigns', [
            'campaigns' => Campaign::query()->where('is_public', true)->latest('created_at')->paginate(9),
        ]);
    }
}
