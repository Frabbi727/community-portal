@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Public Dashboard</p>
    <h1>Community Activity Center</h1>
    <p>Anyone can see ongoing activities, events, celebrations, mourning banners, and notices.</p>
</section>

@if($occasionBanners->isNotEmpty())
<section class="occasion-banner-strip">
    @foreach($occasionBanners as $banner)
        <article class="occasion-banner occasion-{{ $banner->type }}">
            <div>
                <p class="eyebrow">{{ ucfirst($banner->type) }} Banner</p>
                <h3>{{ $banner->title }}</h3>
                <p>{{ $banner->message ?: 'Community announcement' }}</p>
            </div>
            @if($banner->image_url)
                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="occasion-banner-image">
            @endif
        </article>
    @endforeach
</section>
@endif

<section class="section-grid">
    <article class="card">
        <h2>Community About</h2>
        <p>{{ $communityAbout }}</p>
    </article>

    <article class="card">
        <h2>Regular Activity</h2>
        <div class="stack-list">
            @forelse($activities as $activity)
                <div class="list-item">
                    <div>
                        <p class="list-title">{{ $activity['title'] }}</p>
                        <p class="muted">{{ $activity['type'] }}</p>
                    </div>
                    <span class="muted">{{ $activity['time']?->diffForHumans() }}</span>
                </div>
            @empty
                <p>No activity yet.</p>
            @endforelse
        </div>
    </article>
</section>

<section class="card">
    <h2>Photo Frame Slider</h2>
    <div class="photo-slider" data-photo-slider data-source-url="{{ route('dashboard.slider-images') }}">
        <div class="photo-slider-track">
            <article class="photo-slide is-active" data-photo-slide>
                <div class="photo-slide-caption">
                    <p class="list-title">Loading slider images...</p>
                    <p class="muted">Please wait while we load latest activity photos.</p>
                </div>
            </article>
        </div>
        <div class="photo-slider-controls">
            <button type="button" class="btn btn-subtle" data-slider-prev>Previous</button>
            <div class="photo-slider-dots" data-slider-dots></div>
            <button type="button" class="btn btn-subtle" data-slider-next>Next</button>
        </div>
    </div>
</section>

<section class="card">
    <h2>Community Photo Posts</h2>
    <div class="photo-grid">
        @forelse($communityPosts as $post)
            <article class="photo-card">
                @if($post->image_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="photo-thumb">
                @endif
                <div class="photo-meta">
                    <p class="list-title">{{ $post->title }}</p>
                    <p class="muted">By {{ $post->user->name }}</p>
                    @if($post->body)
                        <p>{{ $post->body }}</p>
                    @endif
                </div>
            </article>
        @empty
            <p>No posts yet.</p>
        @endforelse
    </div>
</section>

<section class="section-grid">
    <article class="card">
        <h2>Latest Notices</h2>
        @forelse($privateNotices as $notice)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $notice->title }}</p>
                    <p>{{ $notice->summary ?: \Illuminate\Support\Str::limit($notice->body, 95) }}</p>
                </div>
                <span class="badge">{{ ucfirst($notice->type) }}</span>
            </div>
        @empty
            <p>No notices yet.</p>
        @endforelse
    </article>

    <article class="card">
        <h2>Campaign Updates</h2>
        @forelse($privateCampaigns as $campaign)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $campaign->title }}</p>
                    <p>{{ \Illuminate\Support\Str::limit($campaign->description, 95) }}</p>
                </div>
                <span class="badge badge-accent">{{ ucfirst($campaign->status) }}</span>
            </div>
        @empty
            <p>No campaign update yet.</p>
        @endforelse
    </article>
</section>

<section class="card">
    <h2>New Member Photo Frame</h2>
    <div class="member-frame-grid">
        @forelse($newMembers as $member)
            <article class="member-frame">
                @if($member->profile_photo_url)
                    <img src="{{ $member->profile_photo_url }}" alt="{{ $member->full_name }}" class="member-frame-image">
                @else
                    <div class="member-frame-fallback">{{ strtoupper(substr($member->full_name, 0, 1)) }}</div>
                @endif
                <h3>{{ $member->full_name }}</h3>
                <p class="muted">{{ $member->role ?: 'Community Member' }}</p>
                <p>{{ $member->bio ?: 'Community member profile.' }}</p>
            </article>
        @empty
            <p>No members yet.</p>
        @endforelse
    </div>
</section>
@endsection
