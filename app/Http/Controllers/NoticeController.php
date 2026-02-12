<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $query = Notice::query()->published()->latest('published_at');

        if (! auth()->check()) {
            $query->where('is_public', true);
        }

        return view('pages.notices', [
            'notices' => $query->paginate(10),
        ]);
    }
}
