@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Banner</p>
    <h1>Post Occasion Banner</h1>
    <p>Create celebration, mourning, or other occasion banner.</p>
</section>

<section class="card form-card">
    <form method="POST" action="{{ route('admin.media.banner.store') }}" enctype="multipart/form-data" class="form-grid">
        @csrf
        <label>Title<input type="text" name="title" required></label>
        <label>Type
            <select name="type" required>
                <option value="celebration">Celebration</option>
                <option value="mourning">Death/Mourning</option>
                <option value="occasion">Occasion</option>
            </select>
        </label>
        <label>Message<textarea name="message" rows="3"></textarea></label>
        <label>Starts On<input type="date" name="starts_on"></label>
        <label>Ends On<input type="date" name="ends_on"></label>
        <label>Banner Image (optional)<input type="file" name="image" accept="image/*"></label>
        <label class="check-line"><input type="checkbox" name="is_active" value="1" checked>Active banner</label>
        <button class="btn btn-primary" type="submit">Post Banner</button>
    </form>
</section>
@endsection
