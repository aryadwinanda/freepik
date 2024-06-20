<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Free Images</title>
        <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.3/css/bootstrap.min.css') }}" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.home.index') }}">
                    FreeImages
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="mt-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Login
                            </div>
                            <form method="POST" action="{{ route('admin.login.post') }}" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    @if (flash()->message)
                                        <div class="alert alert-{{ flash()->class }}">
                                            {{ flash()->message }}
                                        </div>
                                    @endif
                                    
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required />
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>