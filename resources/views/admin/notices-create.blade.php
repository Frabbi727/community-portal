@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Notices</p>
    <h1>Post Notice</h1>
    <p>Create notice/event/celebration/memorial post.</p>
</section>

<section class="card form-card">
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
        <button class="btn btn-primary" type="submit">Post Notice</button>
    </form>
</section>
@endsection
