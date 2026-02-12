@extends('layouts.app')

@section('content')
<section class="hero">
    <div>
        <p class="eyebrow">Community Hub</p>
        <h1>Stay up to date with members, notices, celebrations, and campaigns.</h1>
        <p class="lead">A single portal where everyone can see what is happening and approved members can access private updates.</p>
        <div class="hero-actions">
            @auth
                <a href="{{ route('membership.create') }}" class="btn btn-primary">Apply for Membership</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Register First</a>
            @endauth
            <a href="{{ route('notices.index') }}" class="btn btn-subtle">View Updates</a>
        </div>
    </div>

    <aside class="hero-panel">
        <h3>Membership Flow</h3>
        <ol>
            <li>Register account</li>
            <li>Submit membership application</li>
            <li>Admin review and approval</li>
            <li>Get access to member area</li>
        </ol>
    </aside>
</section>

<section class="stats-grid">
    <article class="card stat">
        <h3>{{ $membersCount }}</h3>
        <p>Active Public Members</p>
    </article>
    <article class="card stat">
        <h3>{{ $activeCampaignsCount }}</h3>
        <p>Active Campaigns</p>
    </article>
    <article class="card stat">
        <h3>{{ $latestNotices->count() }}</h3>
        <p>Recent Public Notices</p>
    </article>
</section>

<section class="section-grid">
    <article class="card">
        <h2>Latest Notices</h2>
        @forelse($latestNotices as $notice)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $notice->title }}</p>
                    <p>{{ $notice->summary ?: \Illuminate\Support\Str::limit($notice->body, 90) }}</p>
                </div>
                <span class="badge">{{ ucfirst($notice->type) }}</span>
            </div>
        @empty
            <p>No notices published yet.</p>
        @endforelse
    </article>

    <article class="card">
        <h2>Community Campaigns</h2>
        @forelse($latestCampaigns as $campaign)
            <div class="list-item">
                <div>
                    <p class="list-title">{{ $campaign->title }}</p>
                    <p>{{ $campaign->summary ?: \Illuminate\Support\Str::limit($campaign->description, 90) }}</p>
                </div>
                <span class="badge badge-accent">{{ ucfirst($campaign->status) }}</span>
            </div>
        @empty
            <p>No campaigns available.</p>
        @endforelse
    </article>
</section>
@endsection
