@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Slider</p>
    <h1>Slider Image List</h1>
    <p>Click an item to change photo, activate/deactivate, or delete.</p>
</section>

<section class="stack-list">
    @forelse($sliderItems as $item)
        <details class="admin-item card">
            <summary class="admin-item-summary">
                <div>
                    <p class="list-title">{{ $item->title }}</p>
                    <p class="muted">Order {{ $item->sort_order }} | By {{ $item->user->name }}</p>
                </div>
                <span class="badge">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
            </summary>
            <div class="admin-item-body">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="photo-thumb">
                <p class="muted">{{ $item->activity_note ?: 'No activity note' }}</p>
                <form method="POST" action="{{ route('admin.media.slider.replace-image', $item) }}" enctype="multipart/form-data" class="inline-form">
                    @csrf
                    <input type="file" name="image" accept="image/*" required>
                    <button class="btn btn-subtle" type="submit">Change Photo</button>
                </form>
                <div class="inline-actions">
                    <form method="POST" action="{{ route('admin.media.slider.toggle', $item) }}">@csrf<button class="btn btn-subtle" type="submit">{{ $item->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                    <form method="POST" action="{{ route('admin.media.slider.destroy', $item) }}">@csrf @method('DELETE')<button class="btn btn-subtle" type="submit">Delete</button></form>
                </div>
            </div>
        </details>
    @empty
        <p>No slider item yet.</p>
    @endforelse
</section>
@endsection
