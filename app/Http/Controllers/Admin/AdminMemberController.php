<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.members-manager', [
            'users' => User::query()->with('member')->latest('created_at')->paginate(20),
        ]);
    }

    public function updateMembership(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'membership_status' => ['required', 'in:none,pending,approved,rejected'],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'membership_status' => $validated['membership_status'],
        ]);

        if ($validated['membership_status'] === 'approved') {
            $member = $user->member;

            if (! $member) {
                $member = Member::query()->create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'slug' => Str::slug($user->name.'-'.$user->id),
                    'email' => $user->email,
                    'joined_on' => now(),
                    'is_public' => true,
                    'is_active' => true,
                ]);
            }

            if (! empty($validated['designation'])) {
                $member->update(['role' => $validated['designation']]);
            }
        }

        return back()->with('success', 'Member status/designation updated.');
    }

    public function toggleAdmin(User $user): RedirectResponse
    {
        $user->update([
            'is_admin' => ! $user->is_admin,
        ]);

        return back()->with('success', 'User admin role updated.');
    }
}
