<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Tulis</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">Toko Alat Tulis</h1>
                <p class="text-muted mb-0">
                    Temukan kebutuhan alat tulis Anda
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">

                @auth
                    <a href="{{ route('cart.index') }}" class="btn btn-primary">
                        Keranjang
                        <span class="badge text-bg-light">
                            {{ collect(session('cart', []))->sum() }}
                        </span>
                    </a>

                    <a href="{{ route('riwayat.index') }}" class="btn btn-outline-secondary">
                        Riwayat
                    </a>

                    <form method="POST" action="{{ url('/logout') }}" class="m-0">
                        @csrf

                        <button type="submit" class="btn btn-outline-danger">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login
                    </a>
                @endauth

            </div>

        </div>

        {{-- Welcome --}}
        @auth
            <div class="alert alert-light border mb-4">
                Selamat datang,
                <strong>{{ auth()->user()->nama_lengkap }}</strong>!
            </div>
        @endauth

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Cart error --}}
        @if ($errors->has('cart'))
            <div class="alert alert-danger">
                {{ $errors->first('cart') }}
            </div>
        @endif

        {{-- Product list --}}
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="mb-4">
                    <h2 class="h4 mb-1">Daftar Barang</h2>
                    <p class="text-muted mb-0">
                        Pilih barang yang ingin dibeli
                    </p>
                </div>

                <div class="row g-4">

                    @forelse ($products as $product)

                        <div class="col-md-6 col-lg-4 col-xl-3">

                            <div class="card h-100">

                                @if ($product->gambar)
                                    <img
                                        src="{{ asset('images/products/' . $product->gambar) }}"
                                        alt="{{ $product->nama_barang }}"
                                        class="card-img-top p-3"
                                        style="height: 200px; object-fit: contain;"
                                    >
                                @endif

                                <div class="card-body d-flex flex-column">

                                    <h3 class="h5">
                                        {{ $product->nama_barang }}
                                    </h3>

                                    <p class="text-muted small">
                                        {{ $product->deskripsi }}
                                    </p>

                                    <p class="fw-semibold mb-2" style="color: #6f4e37;">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </p>

                                    <p class="mb-3">
                                        Stok:
                                        <strong>{{ $product->stok }}</strong>
                                    </p>

                                    <div class="mt-auto">

                                        @auth

                                            @if ($product->stok > 0)

                                                <form
                                                    method="POST"
                                                    action="{{ route('cart.add', $product) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary w-100"
                                                    >
                                                        Masukkan ke keranjang
                                                    </button>
                                                </form>

                                            @else

                                                <button
                                                    type="button"
                                                    class="btn btn-secondary w-100"
                                                    disabled
                                                >
                                                    Stok habis
                                                </button>

                                            @endif

                                        @else

                                            <a
                                                href="{{ route('login') }}"
                                                class="btn btn-primary w-100"
                                            >
                                                Login untuk membeli
                                            </a>

                                        @endauth

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">
                            <div class="alert alert-secondary mb-0">
                                Belum ada produk.
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>
        </div>

    </div>

</body>

</html>