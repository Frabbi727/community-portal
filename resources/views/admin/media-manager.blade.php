@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin</p>
    <h1>Media Manager</h1>
    <p>Upload slider photos with activity text and manage celebration/mourning occasion banners.</p>
</section>

<section class="section-grid">
    <article class="card form-card">
        <h2>Upload Slider Photo</h2>
        <form method="POST" action="{{ route('admin.media.slider.store') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            <label>Title
                <input type="text" name="title" required>
            </label>
            <label>Activity Note
                <textarea name="activity_note" rows="3"></textarea>
            </label>
            <label>Activity Date
                <input type="date" name="activity_date">
            </label>
            <label>Order Priority (0 first)
                <input type="number" name="sort_order" min="0" value="0">
            </label>
            <label>Image
                <input type="file" name="image" accept="image/*" required>
            </label>
            <label class="check-line">
                <input type="checkbox" name="is_active" value="1" checked>
                Active in slider
            </label>
            <button class="btn btn-primary" type="submit">Upload Slider Item</button>
        </form>
    </article>

    <article class="card form-card">
        <h2>Create Occasion Banner</h2>
        <form method="POST" action="{{ route('admin.media.banner.store') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            <label>Title
                <input type="text" name="title" required>
            </label>
            <label>Type
                <select name="type" required>
                    <option value="celebration">Celebration</option>
                    <option value="mourning">Death/Mourning</option>
                    <option value="occasion">Occasion</option>
                </select>
            </label>
            <label>Message
                <textarea name="message" rows="3"></textarea>
            </label>
            <label>Starts On
                <input type="date" name="starts_on">
            </label>
            <label>Ends On
                <input type="date" name="ends_on">
            </label>
            <label>Banner Image (optional)
                <input type="file" name="image" accept="image/*">
            </label>
            <label class="check-line">
                <input type="checkbox" name="is_active" value="1" checked>
                Active banner
            </label>
            <button class="btn btn-primary" type="submit">Create Banner</button>
        </form>
    </article>
</section>

<section class="card">
    <h2>Slider Items</h2>
    <div class="stack-list">
        @forelse($sliderItems as $item)
            <article class="photo-card">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="photo-thumb">
                <div class="photo-meta">
                    <p class="list-title">{{ $item->title }}</p>
                    <p class="muted">{{ $item->activity_note ?: 'No activity note' }}</p>
                    <p class="muted">By {{ $item->user->name }} | Order: {{ $item->sort_order }} | {{ $item->is_active ? 'Active' : 'Inactive' }}</p>
                    <form method="POST" action="{{ route('admin.media.slider.replace-image', $item) }}" enctype="multipart/form-data" class="inline-form">
                        @csrf
                        <input type="file" name="image" accept="image/*" required>
                        <button class="btn btn-subtle" type="submit">Change Photo</button>
                    </form>
                    <div class="inline-actions">
                        <form method="POST" action="{{ route('admin.media.slider.toggle', $item) }}">@csrf<button class="btn btn-subtle" type="submit">{{ $item->is_active ? 'Disable' : 'Enable' }}</button></form>
                        <form method="POST" action="{{ route('admin.media.slider.destroy', $item) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
                    </div>
                </div>
            </article>
        @empty
            <p>No slider item yet.</p>
        @endforelse
    </div>
</section>

<section class="card">
    <h2>Occasion Banners</h2>
    <div class="stack-list">
        @forelse($banners as $banner)
            <article class="card">
                <p class="list-title">{{ $banner->title }}</p>
                <p class="muted">Type: {{ ucfirst($banner->type) }} | {{ $banner->is_active ? 'Active' : 'Inactive' }}</p>
                <p>{{ $banner->message ?: 'No message' }}</p>
                @if($banner->image_url)
                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="banner-thumb">
                @endif
                <form method="POST" action="{{ route('admin.media.banner.replace-image', $banner) }}" enctype="multipart/form-data" class="inline-form">
                    @csrf
                    <input type="file" name="image" accept="image/*" required>
                    <button class="btn btn-subtle" type="submit">Change Banner Photo</button>
                </form>
                <div class="inline-actions">
                    <form method="POST" action="{{ route('admin.media.banner.toggle', $banner) }}">@csrf<button class="btn btn-subtle" type="submit">{{ $banner->is_active ? 'Disable' : 'Enable' }}</button></form>
                    <form method="POST" action="{{ route('admin.media.banner.destroy', $banner) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
                </div>
            </article>
        @empty
            <p>No occasion banner yet.</p>
        @endforelse
    </div>
</section>
@endsection
