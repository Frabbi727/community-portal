<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.membership-form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'interests' => ['nullable', 'string', 'max:3000'],
            'motivation' => ['required', 'string', 'max:3000'],
        ]);

        MembershipApplication::query()->create([
            ...$validated,
            'submitted_at' => now(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your membership form has been submitted successfully.');
    }
}
