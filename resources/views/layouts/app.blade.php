<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Free Images</title>
        <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.3/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">FreeImages</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if(auth()->check())
                            @if(auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" target="blank" aria-current="page" href="{{ route("admin.home.index") }}">Halaman Admin</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route("favourite") }}">Favorit</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route("logout") }}">Logout</a>
                            </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route("login") }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route("register") }}">Register</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mt-4">
            @yield('content')
        </div>

        <script src="{{ asset('assets/jquery.js') }}"></script>
        <script src="{{ asset('assets/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>