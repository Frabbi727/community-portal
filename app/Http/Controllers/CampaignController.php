<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        $query = Campaign::query()->latest('created_at');

        if (! auth()->check()) {
            $query->where('is_public', true);
        }

        return view('pages.campaigns', [
            'campaigns' => $query->paginate(9),
        ]);
    }
}
