@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Members Only</p>
    <h1>Private Member Area</h1>
    <p>Only registered members can view this section.</p>
</section>

<section class="section-grid">
    <article class="card">
        <h2>Private Notices</h2>
        @forelse($privateNotices as $notice)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $notice->title }}</p>
                    <p>{{ $notice->summary ?: \Illuminate\Support\Str::limit($notice->body, 95) }}</p>
                </div>
                <span class="badge">{{ ucfirst($notice->type) }}</span>
            </div>
        @empty
            <p>No private notices yet.</p>
        @endforelse
    </article>

    <article class="card">
        <h2>Private Campaign Updates</h2>
        @forelse($privateCampaigns as $campaign)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $campaign->title }}</p>
                    <p>{{ \Illuminate\Support\Str::limit($campaign->description, 95) }}</p>
                </div>
                <span class="badge badge-accent">{{ ucfirst($campaign->status) }}</span>
            </div>
        @empty
            <p>No private campaign update yet.</p>
        @endforelse
    </article>
</section>

<section class="card">
    <h2>Member Contacts</h2>
    <div class="stack-list">
        @forelse($members as $member)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $member->full_name }}</p>
                    <p>{{ $member->role ?: 'Community Member' }}</p>
                </div>
                <div>
                    <p>{{ $member->email ?: 'No email' }}</p>
                    <p>{{ $member->phone ?: 'No phone' }}</p>
                </div>
            </div>
        @empty
            <p>No members listed.</p>
        @endforelse
    </div>
</section>
@endsection
