<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sanskrit Shloka App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Sanskrit Shloka</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @elseif(auth()->user()->role === 'approver')
                        <li class="nav-item"><a class="nav-link" href="{{ route('approver.dashboard') }}">Approver Dashboard</a></li>
                    @elseif(auth()->user()->role === 'fixed_entry' || auth()->user()->role === 'variable_entry')
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @else
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            @auth
            <aside class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Shlokas
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 80vh; overflow-y: auto;">
                        @if(isset($all_shlokas) && $all_shlokas->count() > 0)
                            @foreach($all_shlokas as $shloka)
                                <a href="{{ route('shlokas.show', $shloka->id) }}"
                                   class="list-group-item list-group-item-action {{ request()->is('shlokas/'.$shloka->id) ? 'active' : '' }}">
                                    Shloka #{{ $shloka->shloka_id }}
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item">No shlokas found.</div>
                        @endif
                    </div>
                </div>
            </aside>
            <main class="col-md-9">
                @yield('content')
            </main>
            @else
            <main class="col-12">
                @yield('content')
            </main>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
