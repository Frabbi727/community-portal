@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Announcements</p>
    <h1>Notices, Celebrations, Events, and Memorials</h1>
    <p>Important updates for the whole community.</p>
</section>

<section class="stack-list">
    @forelse($notices as $notice)
        <article class="card">
            <div class="row-between">
                <h2>{{ $notice->title }}</h2>
                <span class="badge">{{ ucfirst($notice->type) }}</span>
            </div>
            <p class="muted">Published: {{ $notice->published_at?->format('M d, Y') }}</p>
            <p>{{ $notice->summary }}</p>
            <p>{{ $notice->body }}</p>
            @if(!$notice->is_public)
                <p class="private-note">Members only notice.</p>
            @endif
        </article>
    @empty
        <article class="card"><p>No notices available.</p></article>
    @endforelse
</section>

<div class="pagination-wrap">{{ $notices->links() }}</div>
@endsection
