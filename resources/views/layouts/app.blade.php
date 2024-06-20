<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                {{-- <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">Beranda</a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </nav>

        <div class="mt-4">
            @yield('content')
        </div>

        <script src="{{ asset('assets/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>