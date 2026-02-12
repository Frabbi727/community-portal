@extends('layouts.app')

@section('content')
<section class="auth-shell">
    <article class="card form-card auth-card">
        <h1>Member Login</h1>
        <p>Login to access private member updates.</p>

        <form method="POST" action="{{ route('login.perform') }}" class="form-grid">
            @csrf
            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <label class="check-line">
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
    </article>
</section>
@endsection
