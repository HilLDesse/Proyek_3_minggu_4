<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    Riwayat Pesanan
                </h1>

                <p class="text-muted mb-0">
                    Daftar pesanan yang telah dilakukan
                </p>
            </div>

            <a href="{{ url('/') }}" class="btn btn-primary">
                Kembali ke toko
            </a>

        </div>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($orders as $order)

                <div class="card shadow-sm mb-4">

                    <div class="card-body">

                        {{-- Informasi pesanan --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h2 class="h5 mb-1">
                                    Pesanan {{ $order->id_order }}
                                </h2>

                                <p class="text-muted mb-1">
                                    Tanggal:
                                    {{ $order->tanggal_order->format('d-m-Y H:i') }}
                                </p>

                                <p class="text-muted mb-0">
                                    Alamat:
                                    {{ $order->alamat_pengiriman }}
                                </p>
                            </div>

                            <span class="badge text-bg-success">
                                Berhasil
                            </span>

                        </div>

                        <hr>

                        {{-- Detail barang --}}
                        <h3 class="h6 mb-3">
                            Detail Barang
                        </h3>

                        <div class="table-responsive">

                            <table class="table table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->details as $detail)

                                                            <tr>

                                                                <td>
                                                                    {{ $detail->product->nama_barang }}
                                                                </td>

                                                                <td>
                                                                    {{ $detail->Jumlah_beli }}
                                                                </td>

                                                                <td>
                                                                    Rp {{ number_format(
                                            $detail->harga_satuan,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                                                </td>

                                                                <td>
                                                                    Rp {{ number_format(
                                            $detail->harga_satuan * $detail->Jumlah_beli,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                                                </td>

                                                            </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        {{-- Total --}}
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">

                            <strong>
                                Total Pesanan
                            </strong>

                            <strong style="color: #6f4e37;">
                                Rp {{ number_format(
                $order->total_harga,
                0,
                ',',
                '.'
            ) }}
                            </strong>

                        </div>

                    </div>

                </div>

        @empty

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="alert alert-secondary mb-0">
                        Belum ada pesanan.
                    </div>

                </div>

            </div>

        @endforelse

    </div>

</body>

</html>