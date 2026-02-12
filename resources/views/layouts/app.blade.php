<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Community Portal') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="site-shell">
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="{{ route('home') }}" class="brand">Community Portal</a>
            <button class="menu-toggle" type="button" aria-label="Toggle menu" data-menu-toggle>Menu</button>
            <nav class="main-nav" data-menu>
                <a href="{{ route('members.index') }}">Members</a>
                <a href="{{ route('notices.index') }}">Notices</a>
                <a href="{{ route('campaigns.index') }}">Campaigns</a>
                <a href="{{ route('membership.create') }}">Membership Form</a>
            </nav>
            <div class="auth-links">
                @auth
                    <a href="{{ route('member.dashboard') }}" class="btn btn-subtle">Member Area</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-subtle">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="page-content container">
        @if (session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="flash-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>Built for transparent community updates and member engagement.</p>
        </div>
    </footer>
</div>
</body>
</html>
