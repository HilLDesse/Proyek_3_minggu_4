<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Dashboard</h1>

                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf

                        <button type="submit" class="btn btn-outline-danger">
                            Logout
                        </button>
                    </form>
                </div>

                <div class="mb-4">
                    <h2 class="h5">
                        Selamat datang, {{ auth()->user()->nama_lengkap }}!
                    </h2>

                    <p class="text-muted mb-0">
                        Halaman ini hanya bisa dibuka setelah login.
                    </p>
                </div>

                <div class="border rounded p-3 bg-light">
                    <p class="mb-0">
                        <strong>Username:</strong>
                        {{ auth()->user()->username }}
                    </p>
                </div>

            </div>
        </div>

    </div>

</body>

</html>