<?php

namespace App\Http\Controllers;

use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function create(Request $request): View
    {
        $latestApplication = $request->user()->membershipApplications()->latest('submitted_at')->first();

        return view('pages.membership-form', [
            'latestApplication' => $latestApplication,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $latestApplication = $user->membershipApplications()->latest('submitted_at')->first();

        if ($user->isApprovedMember()) {
            return redirect()->route('dashboard');
        }

        if ($latestApplication && $latestApplication->status === 'pending') {
            return back()->withErrors(['membership' => 'You already have a pending membership application.']);
        }

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'interests' => ['nullable', 'string', 'max:3000'],
            'motivation' => ['required', 'string', 'max:3000'],
        ]);

        MembershipApplication::query()->create([
            ...$validated,
            'user_id' => $user->id,
            'full_name' => $user->name,
            'email' => $user->email,
            'submitted_at' => now(),
            'status' => 'pending',
        ]);

        $user->update(['membership_status' => 'pending']);

        return back()->with('success', 'Application submitted. Admin review is pending.');
    }
}
