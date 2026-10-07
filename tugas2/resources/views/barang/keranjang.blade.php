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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Keranjang Belanja</h1>
                <p class="text-muted mb-0">
                    Keranjang belanja tanpa login
                </p>
            </div>

            <a href="{{ url('/') }}" class="btn btn-outline-primary">
                Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <h2 class="h5 mb-4">Isi Keranjang</h2>

                <div id="isiKeranjang"></div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <strong>Total</strong>

                    <strong id="total" class="text-primary">
                        Rp 0
                    </strong>
                </div>

                <div class="mt-3">
                    <button type="button" id="btnKosongkan" class="btn btn-outline-danger">
                        Kosongkan keranjang
                    </button>
                </div>

            </div>
        </div>

    </div>

    <script>

        const KUNCI_KERANJANG = 'keranjang';

        const produk = @json($barangs);

        function rupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

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

        function tampilkanKeranjang() {

            const container =
                document.getElementById('isiKeranjang');

            const totalElement =
                document.getElementById('total');

            const keranjang =
                bacaKeranjang();

            container.innerHTML = '';

            let total = 0;

            if (keranjang.length === 0) {

                container.innerHTML = `
                    <div class="alert alert-secondary">
                        Keranjang kosong.
                    </div>
                `;

                totalElement.textContent = 'Rp 0';

                return;
            }

            keranjang.forEach(function (item) {

                const p = produk.find(function (produk) {

                    return Number(produk.id) === Number(item.id);

                });

                if (!p) {
                    return;
                }

                const jumlah =
                    Number(item.jumlah);

                const subtotal =
                    Number(p.harga) * jumlah;

                total += subtotal;

                const div =
                    document.createElement('div');

                div.className =
                    'border rounded p-3 mb-3';

                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <h3 class="h6 mb-1">
                                ${p.nama}
                            </h3>

                            <p class="text-muted mb-2">
                                ${rupiah(p.harga)} × ${jumlah}
                                = <strong>${rupiah(subtotal)}</strong>
                            </p>

                            <div class="d-flex align-items-center gap-2">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    onclick="kurangi(${p.id})"
                                >
                                    −
                                </button>

                                <span class="fw-semibold">
                                    ${jumlah}
                                </span>

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    onclick="tambah(${p.id})"
                                >
                                    +
                                </button>

                            </div>
                        </div>

                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm"
                            onclick="hapus(${p.id})"
                        >
                            Hapus
                        </button>

                    </div>
                `;

                container.appendChild(div);

            });

            totalElement.textContent =
                rupiah(total);
        }

        function tambah(id) {

            const keranjang =
                bacaKeranjang();

            const item =
                keranjang.find(function (item) {
                    return Number(item.id) === Number(id);
                });

            const p =
                produk.find(function (produk) {
                    return Number(produk.id) === Number(id);
                });

            if (!item || !p) {
                return;
            }

            if (item.jumlah >= Number(p.stok)) {

                alert('Jumlah tidak boleh melebihi stok.');

                return;
            }

            item.jumlah++;

            simpanKeranjang(keranjang);

            tampilkanKeranjang();
        }

        function kurangi(id) {

            const keranjang =
                bacaKeranjang();

            const index =
                keranjang.findIndex(function (item) {
                    return Number(item.id) === Number(id);
                });

            if (index === -1) {
                return;
            }

            keranjang[index].jumlah--;

            if (keranjang[index].jumlah <= 0) {

                keranjang.splice(index, 1);

            }

            simpanKeranjang(keranjang);

            tampilkanKeranjang();
        }

        function hapus(id) {

            let keranjang =
                bacaKeranjang();

            keranjang =
                keranjang.filter(function (item) {
                    return Number(item.id) !== Number(id);
                });

            simpanKeranjang(keranjang);

            tampilkanKeranjang();
        }

        document
            .getElementById('btnKosongkan')
            .addEventListener('click', function () {

                localStorage.removeItem(
                    KUNCI_KERANJANG
                );

                tampilkanKeranjang();

            });

        tampilkanKeranjang();

    </script>

</body>

</html>