@extends('layouts.app')

@section('content')
<section class="section-header">
    <p class="eyebrow">Join Us</p>
    <h1>Membership Application Form</h1>
    <p>Submit your details and our committee will review your application.</p>
</section>

<section class="card form-card">
    <form action="{{ route('membership.store') }}" method="POST" class="form-grid">
        @csrf
        <label>
            Full Name
            <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        </label>
        <label>
            Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
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
        <button class="btn btn-primary" type="submit">Submit Form</button>
    </form>
</section>
@endsection
