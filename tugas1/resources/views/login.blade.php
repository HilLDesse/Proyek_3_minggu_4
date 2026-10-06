<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h1 class="h3 mb-2">Login</h1>
                            <p class="text-muted mb-0">
                                Masuk untuk membuka dashboard
                            </p>
                        </div>

                        @if ($errors->has('login'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('login') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    Username
                                </label>

                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Masuk
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>