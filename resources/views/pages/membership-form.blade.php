@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Membership Workflow</p>
    <h1>Apply for Membership</h1>
    <p>Flow: Register account -> Submit application -> Admin review -> Membership approval.</p>
</section>

<section class="card form-card">
    @if(auth()->user()->membership_status === 'approved')
        <p class="private-note">Your membership is approved.</p>
        <a class="btn btn-primary" href="{{ route('dashboard') }}">Go to Public Dashboard</a>
    @elseif($latestApplication && $latestApplication->status === 'pending')
        <p class="private-note">Your application is pending admin review.</p>
    @else
        <p><strong>Account:</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>

        <form action="{{ route('membership.store') }}" method="POST" class="form-grid">
            @csrf
            <label>
                Phone
                <input type="text" name="phone" value="{{ old('phone') }}" required>
            </label>
            <label>
                Address
                <input type="text" name="address" value="{{ old('address') }}">
            </label>
            <label>
                Occupation
                <input type="text" name="occupation" value="{{ old('occupation') }}">
            </label>
            <label>
                Interests
                <textarea name="interests" rows="4">{{ old('interests') }}</textarea>
            </label>
            <label>
                Why do you want to join?
                <textarea name="motivation" rows="5" required>{{ old('motivation') }}</textarea>
            </label>
            <button class="btn btn-primary" type="submit">Submit Application</button>
        </form>
    @endif
</section>
@endsection
