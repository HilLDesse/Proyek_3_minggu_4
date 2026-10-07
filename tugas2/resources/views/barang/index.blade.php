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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Toko Alat Tulis</h1>
                <p class="text-muted mb-0">
                    Daftar barang yang tersedia
                </p>
            </div>

            <a href="{{ url('/keranjang') }}" class="btn btn-primary">
                Keranjang
                <span id="jumlahKeranjang" class="badge text-bg-light">0</span>
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <h2 class="h5 mb-4">Daftar Barang</h2>

                <div class="row g-3">

                    @forelse ($barangs as $barang)

                        <div class="col-md-6 col-lg-4">

                            <div class="card h-100">

                                <div class="card-body">

                                    <h3 class="h5">
                                        {{ $barang->nama }}
                                    </h3>

                                    <p class="text-primary fw-semibold mb-2">
                                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                    </p>

                                    <p class="text-muted">
                                        Stok: {{ $barang->stok }}
                                    </p>

                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="tambahKeKeranjang({{ $barang->id }}, {{ $barang->stok }})"
                                        @disabled($barang->stok <= 0)>
                                        {{ $barang->stok > 0 ? 'Masukkan ke keranjang' : 'Stok habis' }}
                                    </button>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">
                            <div class="alert alert-secondary mb-0">
                                Belum ada barang.
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>
        </div>

    </div>

    <script>

        const KUNCI_KERANJANG = 'keranjang';

        function bacaKeranjang() {
            try {
                return JSON.parse(
                    localStorage.getItem(KUNCI_KERANJANG)
                ) || [];
            } catch (error) {
                return [];
            }
        }

        function simpanKeranjang(keranjang) {
            localStorage.setItem(
                KUNCI_KERANJANG,
                JSON.stringify(keranjang)
            );
        }

        function jumlahItemKeranjang() {
            const keranjang = bacaKeranjang();

            return keranjang.reduce(function (total, item) {
                return total + Number(item.jumlah);
            }, 0);
        }

        function tampilkanJumlahKeranjang() {
            document.getElementById('jumlahKeranjang').textContent =
                jumlahItemKeranjang();
        }

        function tambahKeKeranjang(id, stok) {

            const keranjang = bacaKeranjang();

            const item = keranjang.find(function (item) {
                return Number(item.id) === Number(id);
            });

            if (item) {

                if (item.jumlah >= Number(stok)) {
                    alert('Jumlah tidak boleh melebihi stok.');
                    return;
                }

                item.jumlah++;

            } else {

                keranjang.push({
                    id: id,
                    jumlah: 1
                });

            }

            simpanKeranjang(keranjang);

            tampilkanJumlahKeranjang();
        }

        tampilkanJumlahKeranjang();

    </script>

</body>

</html>