@extends('layouts.app')

@section('content')
<section class="auth-shell">
    <article class="card form-card auth-card">
        <h1>Create Account</h1>
        <p>Step 1 of 3: register account first, then submit membership application.</p>

        <form method="POST" action="{{ route('register.perform') }}" class="form-grid">
            @csrf
            <label>
                Name
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>
            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <label>
                Confirm Password
                <input type="password" name="password_confirmation" required>
            </label>
            <button class="btn btn-primary" type="submit">Create Account</button>
        </form>
    </article>
</section>
@endsection
