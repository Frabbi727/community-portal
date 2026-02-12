<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberContentController extends Controller
{
    public function updateProfileImage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profile_photo' => ['required', 'image', 'max:3072'],
        ]);

        $user = $request->user();
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

        if ($member->profile_photo_path) {
            Storage::disk('public')->delete($member->profile_photo_path);
        }

        $path = $validated['profile_photo']->store('member-photos', 'public');

        $member->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function storePost(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:3000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community-posts', 'public');
        }

        CommunityPost::query()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
            'image_path' => $imagePath,
            'is_public' => (bool) ($validated['is_public'] ?? false),
        ]);

        return back()->with('success', 'Post published to community feed.');
    }
}
