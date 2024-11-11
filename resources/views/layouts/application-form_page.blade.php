<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
    <title>@yield('title', 'BPO-BRIDGE')</title>

    @yield('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" style="width: 200px; height: 200px; margin: 10px 60px -20px;">
    </nav>

    <!-- Main Content -->
    <main>
        @yield('application-content')
    </main>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
