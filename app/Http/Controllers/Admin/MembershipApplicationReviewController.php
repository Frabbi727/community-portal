<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MembershipApplicationReviewController extends Controller
{
    public function index(): View
    {
        return view('admin.membership-applications', [
            'applications' => MembershipApplication::query()
                ->with('user')
                ->latest('submitted_at')
                ->paginate(20),
        ]);
    }

    public function approve(Request $request, MembershipApplication $application): RedirectResponse
    {
        if ($application->status !== 'pending') {
            return back()->withErrors(['admin' => 'Only pending applications can be approved.']);
        }

        $application->update([
            'status' => 'approved',
            'review_notes' => $request->string('review_notes')->toString() ?: null,
            'reviewed_at' => now(),
        ]);

        $application->user?->update(['membership_status' => 'approved']);

        if ($application->user && ! $application->user->member) {
            Member::query()->create([
                'user_id' => $application->user->id,
                'full_name' => $application->full_name,
                'slug' => Str::slug($application->full_name.'-'.$application->user->id),
                'email' => $application->email,
                'phone' => $application->phone,
                'location' => $application->address,
                'occupation' => $application->occupation,
                'bio' => $application->interests,
                'joined_on' => now(),
                'is_public' => true,
                'is_active' => true,
            ]);
        }

        return back()->with('success', 'Membership application approved.');
    }

    public function reject(Request $request, MembershipApplication $application): RedirectResponse
    {
        if ($application->status !== 'pending') {
            return back()->withErrors(['admin' => 'Only pending applications can be rejected.']);
        }

        $application->update([
            'status' => 'rejected',
            'review_notes' => $request->string('review_notes')->toString() ?: null,
            'reviewed_at' => now(),
        ]);

        $application->user?->update(['membership_status' => 'rejected']);

        return back()->with('success', 'Membership application rejected.');
    }
}
