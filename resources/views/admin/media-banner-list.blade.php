@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Banner</p>
    <h1>Occasion Banner List</h1>
    <p>Click a banner to manage photo, status, and delete.</p>
</section>

<section class="stack-list">
    @forelse($banners as $banner)
        <details class="admin-item card">
            <summary class="admin-item-summary">
                <div>
                    <p class="list-title">{{ $banner->title }}</p>
                    <p class="muted">{{ ucfirst($banner->type) }}</p>
                </div>
                <span class="badge">{{ $banner->is_active ? 'Active' : 'Inactive' }}</span>
            </summary>
            <div class="admin-item-body">
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
                    <form method="POST" action="{{ route('admin.media.banner.toggle', $banner) }}">@csrf<button class="btn btn-subtle" type="submit">{{ $banner->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                    <form method="POST" action="{{ route('admin.media.banner.destroy', $banner) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
                </div>
            </div>
        </details>
    @empty
        <p>No occasion banner yet.</p>
    @endforelse
</section>
@endsection
