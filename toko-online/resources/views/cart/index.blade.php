<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">Keranjang Belanja</h1>

                <p class="text-muted mb-0">
                    Barang yang akan dibeli
                </p>
            </div>

            <a
                href="{{ url('/') }}"
                class="btn btn-primary"
            >
                Kembali ke toko
            </a>

        </div>

        {{-- Pesan berhasil --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan error --}}
        @if ($errors->has('cart'))
            <div class="alert alert-danger">
                {{ $errors->first('cart') }}
            </div>
        @endif

        {{-- Keranjang --}}
        <div class="card shadow-sm">

            <div class="card-body">

                <div class="mb-4">
                    <h2 class="h4 mb-1">
                        Isi Keranjang
                    </h2>

                    <p class="text-muted mb-0">
                        Periksa barang sebelum melanjutkan checkout.
                    </p>
                </div>

                @if (empty($cart))

                    <div class="alert alert-secondary mb-0">
                        Keranjang masih kosong.
                    </div>

                @else

                    @php
                        $total = 0;
                    @endphp

                    @foreach ($cart as $id => $jumlah)

                        @php
                            $product = $products->get($id);
                        @endphp

                        @if ($product)

                            @php
                                $subtotal = $product->harga * $jumlah;
                                $total += $subtotal;
                            @endphp

                            <div class="border rounded p-3 mb-3">

                                <div class="row align-items-center g-3">

                                    {{-- Informasi produk --}}
                                    <div class="col-md-5">

                                        <h3 class="h5 mb-2">
                                            {{ $product->nama_barang }}
                                        </h3>

                                        <p class="text-muted mb-1">
                                            Harga satuan:
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </p>

                                        <p class="text-muted mb-0">
                                            Stok tersedia:
                                            {{ $product->stok }}
                                        </p>

                                    </div>

                                    {{-- Jumlah --}}
                                    <div class="col-md-3">

                                        <p class="small text-muted mb-2">
                                            Jumlah
                                        </p>

                                        <div class="d-flex align-items-center gap-2">

                                            <form
                                                method="POST"
                                                action="{{ route('cart.decrease', $product) }}"
                                                class="m-0"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-secondary btn-sm"
                                                >
                                                    −
                                                </button>
                                            </form>

                                            <span class="fw-semibold">
                                                {{ $jumlah }}
                                            </span>

                                            <form
                                                method="POST"
                                                action="{{ route('cart.increase', $product) }}"
                                                class="m-0"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-secondary btn-sm"
                                                    @disabled($jumlah >= $product->stok)
                                                >
                                                    +
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-md-2">

                                        <p class="small text-muted mb-1">
                                            Subtotal
                                        </p>

                                        <strong style="color: #6f4e37;">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </strong>

                                    </div>

                                    {{-- Hapus --}}
                                    <div class="col-md-2 text-md-end">

                                        <form
                                            method="POST"
                                            action="{{ route('cart.remove', $product) }}"
                                            class="m-0"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endif

                    @endforeach

                    {{-- Total --}}
                    <div class="border-top pt-3 mt-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <h2 class="h5 mb-0">
                                Total
                            </h2>

                            <h2
                                class="h5 mb-0 fw-bold"
                                style="color: #6f4e37;"
                            >
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h2>

                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex flex-column flex-md-row gap-2 mt-4">

                        <form
                            method="POST"
                            action="{{ route('cart.clear') }}"
                            class="m-0"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-danger"
                            >
                                Kosongkan Keranjang
                            </button>
                        </form>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn btn-primary"
                        >
                            Lanjut ke Checkout
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</body>

</html>