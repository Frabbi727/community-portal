@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Action</p>
    <h1>Community Campaigns</h1>
    <p>Current and upcoming campaigns where people can participate.</p>
</section>

<section class="card-grid">
    @forelse($campaigns as $campaign)
        <article class="card">
            <div class="row-between">
                <h2>{{ $campaign->title }}</h2>
                <span class="badge badge-accent">{{ ucfirst($campaign->status) }}</span>
            </div>
            <p>{{ $campaign->summary ?: $campaign->description }}</p>
            <p><strong>Dates:</strong>
                {{ $campaign->start_date?->format('M d, Y') ?: 'TBA' }}
                -
                {{ $campaign->end_date?->format('M d, Y') ?: 'TBA' }}
            </p>
            @if($campaign->target_amount)
                @php
                    $progress = min(100, (float) ($campaign->current_amount / $campaign->target_amount) * 100);
                @endphp
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                </div>
                <p class="muted">Raised: ${{ number_format((float) $campaign->current_amount, 2) }} / ${{ number_format((float) $campaign->target_amount, 2) }}</p>
            @endif
            @if(!$campaign->is_public)
                <p class="private-note">Members only campaign detail.</p>
            @endif
        </article>
    @empty
        <article class="card"><p>No campaigns available.</p></article>
    @endforelse
</section>

<div class="pagination-wrap">{{ $campaigns->links() }}</div>
@endsection
