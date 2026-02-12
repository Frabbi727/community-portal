<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminNoticeController extends Controller
{
    public function createPage(): View
    {
        return view('admin.notices-create');
    }

    public function listPage(): View
    {
        return view('admin.notices-list', [
            'notices' => Notice::query()->latest('created_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:notice,celebration,memorial,event'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'max:5000'],
            'is_public' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        Notice::query()->create([
            'created_by' => $request->user()->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'type' => $validated['type'],
            'summary' => $validated['summary'] ?? null,
            'body' => $validated['body'],
            'is_public' => (bool) ($validated['is_public'] ?? false),
            'published_at' => $validated['published_at'] ?? now(),
        ]);

        return back()->with('success', 'Notice created successfully.');
    }

    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:notice,celebration,memorial,event'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'max:5000'],
            'is_public' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $notice->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'summary' => $validated['summary'] ?? null,
            'body' => $validated['body'],
            'is_public' => (bool) ($validated['is_public'] ?? false),
            'published_at' => $validated['published_at'] ?? $notice->published_at,
        ]);

        return back()->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        $notice->delete();

        return back()->with('success', 'Notice deleted successfully.');
    }

    public function togglePublic(Notice $notice): RedirectResponse
    {
        $notice->update(['is_public' => ! $notice->is_public]);

        return back()->with('success', 'Notice visibility updated.');
    }
}
