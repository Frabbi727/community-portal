@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Membership</p>
    <h1>Application List</h1>
    <p>Click an application to review details and approve/reject.</p>
</section>

<section class="stack-list">
    @forelse($applications as $application)
        <details class="admin-item card">
            <summary class="admin-item-summary">
                <div>
                    <p class="list-title">{{ $application->full_name }}</p>
                    <p class="muted">{{ $application->email }}</p>
                </div>
                <span class="badge">{{ ucfirst($application->status) }}</span>
            </summary>
            <div class="admin-item-body">
                <p><strong>Phone:</strong> {{ $application->phone }}</p>
                <p><strong>Address:</strong> {{ $application->address ?: 'N/A' }}</p>
                <p><strong>Occupation:</strong> {{ $application->occupation ?: 'N/A' }}</p>
                <p><strong>Interests:</strong> {{ $application->interests ?: 'N/A' }}</p>
                <p><strong>Motivation:</strong> {{ $application->motivation }}</p>

                @if($application->status === 'pending')
                    <div class="review-actions">
                        <form method="POST" action="{{ route('admin.membership-applications.approve', $application) }}" class="inline-form">
                            @csrf
                            <input type="text" name="review_notes" placeholder="Approval note (optional)">
                            <button class="btn btn-primary" type="submit">Approve</button>
                        </form>

                        <form method="POST" action="{{ route('admin.membership-applications.reject', $application) }}" class="inline-form">
                            @csrf
                            <input type="text" name="review_notes" placeholder="Rejection note (optional)">
                            <button class="btn btn-subtle" type="submit">Reject</button>
                        </form>
                    </div>
                @else
                    <p class="muted"><strong>Review note:</strong> {{ $application->review_notes ?: 'N/A' }}</p>
                @endif
            </div>
        </details>
    @empty
        <article class="card"><p>No applications found.</p></article>
    @endforelse
</section>

<div class="pagination-wrap">{{ $applications->links() }}</div>
@endsection
