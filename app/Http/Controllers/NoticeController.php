<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $notices = Notice::query()
            ->published()
            ->where('is_public', true)
            ->latest('published_at')
            ->paginate(10);

        return view('pages.notices', [
            'notices' => $notices,
        ]);
    }
}
