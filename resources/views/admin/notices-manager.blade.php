@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin</p>
    <h1>Notices Manager</h1>
    <p>Create, publish, update, and delete notices/events/celebration/memorial posts.</p>
</section>

<section class="card form-card">
    <h2>Create Notice</h2>
    <form method="POST" action="{{ route('admin.notices.store') }}" class="form-grid">
        @csrf
        <label>Title<input type="text" name="title" required></label>
        <label>Type
            <select name="type" required>
                <option value="notice">Notice</option>
                <option value="event">Event</option>
                <option value="celebration">Celebration</option>
                <option value="memorial">Mourning / Memorial</option>
            </select>
        </label>
        <label>Summary<textarea name="summary" rows="2"></textarea></label>
        <label>Body<textarea name="body" rows="4" required></textarea></label>
        <label>Publish Date<input type="date" name="published_at"></label>
        <label class="check-line"><input type="checkbox" name="is_public" value="1" checked>Public</label>
        <button class="btn btn-primary" type="submit">Create Notice</button>
    </form>
</section>

<section class="stack-list">
    @foreach($notices as $notice)
        <article class="card">
            <div class="row-between">
                <h2>{{ $notice->title }}</h2>
                <span class="badge">{{ ucfirst($notice->type) }}</span>
            </div>
            <p class="muted">{{ $notice->is_public ? 'Public' : 'Private' }} | {{ $notice->published_at?->format('M d, Y') }}</p>
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
                <div class="inline-actions">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
            <div class="inline-actions">
                <form method="POST" action="{{ route('admin.notices.toggle-public', $notice) }}">@csrf<button class="btn btn-subtle" type="submit">Toggle Visibility</button></form>
                <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
            </div>
        </article>
    @endforeach
</section>

<div class="pagination-wrap">{{ $notices->links() }}</div>
@endsection
