@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Slider</p>
    <h1>Post Slider Image</h1>
    <p>Upload image and activity text for dashboard slider.</p>
</section>

<section class="card form-card">
    <form method="POST" action="{{ route('admin.media.slider.store') }}" enctype="multipart/form-data" class="form-grid">
        @csrf
        <label>Title<input type="text" name="title" required></label>
        <label>Activity Note<textarea name="activity_note" rows="3"></textarea></label>
        <label>Activity Date<input type="date" name="activity_date"></label>
        <label>Order Priority<input type="number" name="sort_order" min="0" value="0"></label>
        <label>Image<input type="file" name="image" accept="image/*" required></label>
        <label class="check-line"><input type="checkbox" name="is_active" value="1" checked>Active in slider</label>
        <button class="btn btn-primary" type="submit">Post Slider Image</button>
    </form>
</section>
@endsection
