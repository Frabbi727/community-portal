@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Admin Members</p>
    <h1>Members List</h1>
    <p>Click a user row to promote/update designation/admin role.</p>
</section>

<section class="stack-list">
    @foreach($users as $user)
        <details class="admin-item card">
            <summary class="admin-item-summary">
                <div>
                    <p class="list-title">{{ $user->name }}</p>
                    <p class="muted">{{ $user->email }}</p>
                </div>
                <span class="badge">{{ ucfirst($user->membership_status) }}</span>
            </summary>
            <div class="admin-item-body">
                <p><strong>Current Designation:</strong> {{ $user->member?->role ?: 'N/A' }}</p>
                <p><strong>Admin:</strong> {{ $user->is_admin ? 'Yes' : 'No' }}</p>
                <form method="POST" action="{{ route('admin.members.membership.update', $user) }}" class="form-grid">
                    @csrf
                    <label>Membership Status
                        <select name="membership_status" required>
                            <option value="none" @selected($user->membership_status==='none')>None</option>
                            <option value="pending" @selected($user->membership_status==='pending')>Pending</option>
                            <option value="approved" @selected($user->membership_status==='approved')>Approved (Promote)</option>
                            <option value="rejected" @selected($user->membership_status==='rejected')>Rejected</option>
                        </select>
                    </label>
                    <label>Designation / Role
                        <input type="text" name="designation" value="{{ $user->member?->role }}" placeholder="e.g. Coordinator">
                    </label>
                    <button class="btn btn-primary" type="submit">Update Member</button>
                </form>
                <form method="POST" action="{{ route('admin.members.admin.toggle', $user) }}">
                    @csrf
                    <button class="btn btn-subtle" type="submit">{{ $user->is_admin ? 'Remove Admin' : 'Promote to Admin' }}</button>
                </form>
            </div>
        </details>
    @endforeach
</section>

<div class="pagination-wrap">{{ $users->links() }}</div>
@endsection
