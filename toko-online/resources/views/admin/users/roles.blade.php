<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Role Pengguna</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Pengelolaan Role</h1>
                <p class="text-muted mb-0">
                    Kelola role customer dan staff.
                </p>
            </div>

            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                Kembali ke katalog
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-info">
            Perubahan role hanya dapat diminta oleh admin.
            Akun admin dan akun sendiri tetap dilindungi oleh aturan bisnis.
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>ID Pengguna</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role Saat Ini</th>
                                <th>Ubah Role</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id_user }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->username }}</td>

                                    <td>
                                        <span class="badge text-bg-secondary">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.role.update', $user) }}"
                                            class="d-flex gap-2"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <select
                                                name="role"
                                                class="form-select"
                                                required
                                            >
                                                <option
                                                    value="customer"
                                                    @selected($user->role === 'customer')
                                                >
                                                    Customer
                                                </option>

                                                <option
                                                    value="staff"
                                                    @selected($user->role === 'staff')
                                                >
                                                    Staff
                                                </option>
                                            </select>

                                            <button
                                                type="submit"
                                                class="btn btn-primary text-nowrap"
                                            >
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

</body>

</html>