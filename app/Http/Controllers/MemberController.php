<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $query = Member::query()->where('is_active', true)->latest('joined_on');

        if (! auth()->check()) {
            $query->where('is_public', true);
        }

        return view('pages.members', [
            'members' => $query->paginate(9),
        ]);
    }
}
