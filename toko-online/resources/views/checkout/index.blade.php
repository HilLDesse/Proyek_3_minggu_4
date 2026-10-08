<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">Checkout</h1>

                <p class="text-muted mb-0">
                    Periksa pesanan sebelum dikonfirmasi.
                </p>
            </div>

            <a href="{{ url('/keranjang') }}" class="btn btn-primary">
                Kembali ke keranjang
            </a>

        </div>

        {{-- Error --}}
        @if ($errors->has('checkout'))
            <div class="alert alert-danger">
                {{ $errors->first('checkout') }}
            </div>
        @endif

        <div class="row g-4">

            {{-- Ringkasan pesanan --}}
            <div class="col-lg-7">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h2 class="h4 mb-1">
                            Ringkasan Pesanan
                        </h2>

                        <p class="text-muted mb-4">
                            Barang yang akan dibeli
                        </p>

                        @foreach ($cart as $id => $jumlah)

                            @php
                                $product = $products->get($id);
                            @endphp

                            @if ($product)

                                                <div class="border rounded p-3 mb-3">

                                                    <div class="d-flex justify-content-between align-items-start">

                                                        <div>
                                                            <h3 class="h5 mb-1">
                                                                {{ $product->nama_barang }}
                                                            </h3>

                                                            <p class="text-muted mb-0">
                                                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                                × {{ $jumlah }}
                                                            </p>
                                                        </div>

                                                        <strong style="color: #6f4e37;">
                                                            Rp {{ number_format(
                                    $product->harga * $jumlah,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                                        </strong>

                                                    </div>

                                                </div>

                            @endif

                        @endforeach

                        <div class="border-top pt-3 mt-4">

                            <div class="d-flex justify-content-between align-items-center">

                                <h2 class="h5 mb-0">
                                    Total Pembayaran
                                </h2>

                                <h2 class="h5 mb-0 fw-bold" style="color: #6f4e37;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Form checkout --}}
            <div class="col-lg-5">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h2 class="h4 mb-1">
                            Alamat Pengiriman
                        </h2>

                        <p class="text-muted mb-4">
                            Masukkan alamat tujuan pengiriman.
                        </p>

                        <form method="POST" action="{{ route('checkout.process') }}">

                            @csrf

                            <div class="mb-3">

                                <label for="alamat_pengiriman" class="form-label">
                                    Alamat Pengiriman
                                </label>

                                <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="6" class="form-control"
                                    required>{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>

                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Konfirmasi Checkout
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>