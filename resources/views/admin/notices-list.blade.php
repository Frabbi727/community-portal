@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Notices</p>
    <h1>Notice List</h1>
    <p>Click a notice to view/edit details, activate/deactivate, or delete.</p>
</section>

<section class="stack-list">
    @foreach($notices as $notice)
        <details class="admin-item card">
            <summary class="admin-item-summary">
                <div>
                    <p class="list-title">{{ $notice->title }}</p>
                    <p class="muted">{{ ucfirst($notice->type) }} | {{ $notice->published_at?->format('M d, Y') }}</p>
                </div>
                <span class="badge">{{ $notice->is_public ? 'Active' : 'Inactive' }}</span>
            </summary>
            <div class="admin-item-body">
                <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="form-grid">
                    @csrf
                    @method('PUT')
                    <label>Title<input type="text" name="title" value="{{ $notice->title }}" required></label>
                    <label>Type
                        <select name="type" required>
                            <option value="notice" @selected($notice->type==='notice')>Notice</option>
                            <option value="event" @selected($notice->type==='event')>Event</option>
                            <option value="celebration" @selected($notice->type==='celebration')>Celebration</option>
                            <option value="memorial" @selected($notice->type==='memorial')>Mourning / Memorial</option>
                        </select>
                    </label>
                    <label>Summary<textarea name="summary" rows="2">{{ $notice->summary }}</textarea></label>
                    <label>Body<textarea name="body" rows="3" required>{{ $notice->body }}</textarea></label>
                    <label>Publish Date<input type="date" name="published_at" value="{{ $notice->published_at?->toDateString() }}"></label>
                    <label class="check-line"><input type="checkbox" name="is_public" value="1" @checked($notice->is_public)>Public</label>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
                <div class="inline-actions">
                    <form method="POST" action="{{ route('admin.notices.toggle-public', $notice) }}">@csrf<button class="btn btn-subtle" type="submit">{{ $notice->is_public ? 'Deactivate' : 'Activate' }}</button></form>
                    <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
                </div>
            </div>
        </details>
    @endforeach
</section>

<div class="pagination-wrap">{{ $notices->links() }}</div>
@endsection
