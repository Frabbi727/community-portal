<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        return view('pages.members', [
            'members' => Member::query()->visible()->latest('joined_on')->paginate(9),
        ]);
    }
}
