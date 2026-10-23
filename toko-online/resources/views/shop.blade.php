<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stateless Shopping Cart</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-light">

    <div class="container py-5">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h2 mb-1">Stateless Shopping Cart</h1>

            <p class="text-muted mb-0">
                Simulasi keranjang belanja tanpa penyimpanan session atau cookie.
            </p>
        </div>

        <div class="alert alert-secondary">
            Keranjang hanya tersimpan sementara selama halaman terbuka.
            Refresh halaman akan mengosongkan keranjang.
        </div>

        {{-- Daftar Produk --}}
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h2 class="h4 mb-3">Daftar Produk</h2>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5">Buku Tulis</h3>

                                <p class="fw-semibold" style="color: #6f4e37;">
                                    Rp5.000
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-primary mt-auto"
                                    onclick="add(1)"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5">Pulpen</h3>

                                <p class="fw-semibold" style="color: #6f4e37;">
                                    Rp3.000
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-primary mt-auto"
                                    onclick="add(2)"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5">Penggaris</h3>

                                <p class="fw-semibold" style="color: #6f4e37;">
                                    Rp4.000
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-primary mt-auto"
                                    onclick="add(3)"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- Keranjang --}}
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h2 class="h4 mb-3">Keranjang Belanja</h2>

                <div id="items" class="mb-3">
                    <div class="alert alert-secondary mb-0">
                        Keranjang kosong.
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center border-top pt-3">

                    <h3 class="h5 mb-0">Total</h3>

                    <h3
                        id="total"
                        class="h5 mb-0 fw-bold"
                        style="color: #6f4e37;"
                    >
                        Total: Rp0
                    </h3>

                </div>

                <div class="d-flex flex-wrap gap-2 mt-3">

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="recalculate()"
                    >
                        Hitung Ulang
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        onclick="clearCart()"
                    >
                        Kosongkan Keranjang
                    </button>

                </div>

            </div>

        </div>

        {{-- Respons Laravel --}}
        <div class="card shadow-sm">

            <div class="card-body">

                <h2 class="h4 mb-3">Respons Laravel</h2>

                <p class="text-muted">
                    Hasil perhitungan keranjang yang diterima dari server.
                </p>

                <pre id="response" class="bg-light border rounded p-3 mb-0"
                >Belum ada request.</pre>

            </div>

        </div>

    </div>

    <script>
        // State keranjang hanya berada di memori JavaScript.
        let cart = {};

        async function post(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || JSON.stringify(data)
                );
            }

            return data;
        }

        // Menambahkan produk dengan mengirim state sebelumnya.
        async function add(id) {
            try {
                const data = await post(
                    '/stateless-cart/add',
                    {
                        cart: cart,
                        product_id: id
                    }
                );

                cart = Object.fromEntries(
                    data.items.map(item => [
                        item.id,
                        item.quantity
                    ])
                );

                render(data);

            } catch (error) {
                alert(error.message);
            }
        }

        // Meminta Laravel menghitung ulang isi keranjang.
        async function recalculate() {
            if (Object.keys(cart).length === 0) {
                alert('Keranjang kosong.');
                return;
            }

            try {
                const data = await post(
                    '/stateless-cart/update',
                    {
                        cart: cart
                    }
                );

                cart = Object.fromEntries(
                    data.items.map(item => [
                        item.id,
                        item.quantity
                    ])
                );

                render(data);

            } catch (error) {
                alert(error.message);
            }
        }

        // Menampilkan hasil response Laravel.
        function render(data) {
            const container = document.getElementById('items');

            container.replaceChildren();

            if (data.items.length === 0) {
                const emptyMessage = document.createElement('div');

                emptyMessage.className = 'alert alert-secondary mb-0';
                emptyMessage.textContent = 'Keranjang kosong.';

                container.appendChild(emptyMessage);
            }

            data.items.forEach(item => {
                const row = document.createElement('div');

                row.className = 'border rounded p-3 mb-2';

                row.textContent =
                    `${item.name} × ${item.quantity} = Rp` +
                    item.subtotal.toLocaleString('id-ID');

                container.appendChild(row);
            });

            document.getElementById('total').textContent =
                'Total: Rp' + data.total.toLocaleString('id-ID');

            document.getElementById('response').textContent =
                JSON.stringify(data, null, 2);
        }

        // Mengosongkan state sementara di browser.
        function clearCart() {
            cart = {};

            render({
                items: [],
                total: 0
            });

            document.getElementById('response').textContent =
                'Keranjang dikosongkan di browser. Tidak ada request ke server.';
        }
    </script>

</body>

</html>
