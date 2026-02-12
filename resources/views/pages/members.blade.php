@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Directory</p>
    <h1>Community Members</h1>
    <p>Public profiles are visible to everyone. Approved members can see extra contact details.</p>
</section>

<section class="card-grid">
    @forelse ($members as $member)
        <article class="card">
            <h2>{{ $member->full_name }}</h2>
            <p class="muted">{{ $member->role ?: 'Community Member' }}</p>
            <p>{{ $member->bio ?: 'No profile bio added yet.' }}</p>
            <p><strong>Location:</strong> {{ $member->location ?: 'Not shared' }}</p>
            <p><strong>Occupation:</strong> {{ $member->occupation ?: 'Not shared' }}</p>

            @if(auth()->check() && (auth()->user()->isApprovedMember() || auth()->user()->is_admin))
                <p><strong>Email:</strong> {{ $member->email ?: 'Not shared' }}</p>
                <p><strong>Phone:</strong> {{ $member->phone ?: 'Not shared' }}</p>
            @endif
        </article>
    @empty
        <article class="card">
            <p>No members available yet.</p>
        </article>
    @endforelse
</section>

<div class="pagination-wrap">
    {{ $members->links() }}
</div>
@endsection
