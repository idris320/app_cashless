<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir - Al-Furqon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-weight: 700;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .card-title {
            color: #2c5c1f;
            font-weight: 600;
            border-bottom: 2px solid #2c5c1f;
            padding-bottom: 10px;
        }
        .table th {
            background-color: #2c5c1f;
            color: white;
        }
        .btn-success {
            background-color: #2c5c1f;
            border-color: #2c5c1f;
        }
        .btn-success:hover {
            background-color: #234e1a;
            border-color: #234e1a;
        }
        #notif {
            min-height: 50px;
        }
        .form-control:focus {
            border-color: #2c5c1f;
            box-shadow: 0 0 0 0.2rem rgba(44, 92, 31, 0.25);
        }
        .form-select:focus {
            border-color: #2c5c1f;
            box-shadow: 0 0 0 0.2rem rgba(44, 92, 31, 0.25);
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-cash-register me-2"></i>Kasir Al-Furqon
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light" type="submit">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row gx-3">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-shopping-cart me-2"></i>Transaksi Santri
                        </h4>

                        <form class="row g-3" id="add-item-form">
                            <div class="col-md-5">
                                <select class="form-select" id="barang-select">
                                    <option selected disabled>-- Pilih Barang --</option>
                                    @foreach ($data as $db)
                                        <option value="{{ $db->id }}" data-harga="{{ $db->harga }}">
                                            {{ $db->nama_barang }} - Rp{{ number_format($db->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="jumlah-input" placeholder="Jumlah" min="1" value="1">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success w-100" onclick="tambahBarang()">
                                    <i class="fas fa-plus me-1"></i>Tambah ke Keranjang
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle" id="keranjang">
                                <thead class="table-success">
                                    <tr>
                                        <th>Barang</th>
                                        <th width="120">Jumlah</th>
                                        <th width="150">Harga Satuan</th>
                                        <th width="150">Subtotal</th>
                                        <th width="80">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-outline-danger" onclick="kosongkanKeranjang()">
                                <i class="fas fa-trash me-1"></i>Kosongkan Keranjang
                            </button>
                            <div class="fw-bold fs-5" id="total-display">Total: Rp0</div>
                        </div>

                        <hr class="my-4">
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-user-graduate me-2"></i>Data Santri
                        </h4>
                        <h5 class="mb-3">
                            <i class="fas fa-credit-card me-2"></i>Pembayaran
                        </h5>
                        <form class="row g-3" id="transaksi-form">
                            <div class="col-12">
                                <label for="kartu-id" class="form-label">ID Kartu Santri</label>
                                <input type="text" class="form-control" id="kartu-id" autocomplete="off" placeholder="Scan atau masukkan ID Kartu" required>
                            </div>
                            <div class="col-12">
                                <label for="pin" class="form-label">PIN</label>
                                <input type="password" class="form-control" id="pin" placeholder="Masukkan PIN" required>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" onclick="submitTransaksi()" class="btn btn-success btn-lg">
                                    <i class="fas fa-paper-plane me-1"></i>Submit Transaksi
                                </button>
                            </div>
                        </form>
                        <div id="notif" class="mt-3 alert alert-info" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>Informasi
                        </h5>
                        <div class="alert alert-warning">
                            <small>
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Pastikan ID Kartu dan PIN santri sudah benar sebelum melakukan transaksi.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menambahkan Font Awesome
        document.head.innerHTML += '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';

        let keranjang = [];
        let barangMap = {};

        // Inisialisasi data barang
        @foreach ($data as $db)
            barangMap[{{ $db->id }}] = {
                nama: "{{ $db->nama_barang }}",
                harga: {{ $db->harga }},                
            };
        @endforeach

        function tambahBarang() {
            const select = document.getElementById('barang-select');
            const selectedOption = select.options[select.selectedIndex];
            const jumlah = parseInt(document.getElementById('jumlah-input').value);
            
            if (!select.value || isNaN(jumlah) || jumlah < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih barang dan masukkan jumlah yang valid!'
                });
                return;
            }
            
            const idBarang = select.value;
            const barang = barangMap[idBarang];
            
            // // Cek stok
            // if (jumlah > barang.stok) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Stok Tidak Cukup',
            //         text: `Stok ${barang.nama} hanya tersedia ${barang.stok} item!`
            //     });
            //     return;
            // }
            
            // Cek apakah barang sudah ada di keranjang
            const existingItemIndex = keranjang.findIndex(item => item.id == idBarang);
            
            if (existingItemIndex !== -1) {
                // Jika sudah ada, update jumlah
                const newJumlah = keranjang[existingItemIndex].jumlah + jumlah;
                
                if (newJumlah > barang.stok) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Cukup',
                        text: `Stok ${barang.nama} hanya tersedia ${barang.stok} item!`
                    });
                    return;
                }
                
                keranjang[existingItemIndex].jumlah = newJumlah;
                keranjang[existingItemIndex].subtotal = newJumlah * barang.harga;
            } else {
                // Jika belum ada, tambahkan baru
                keranjang.push({
                    id: idBarang,
                    nama: barang.nama,
                    jumlah: jumlah,
                    harga: barang.harga,
                    subtotal: jumlah * barang.harga
                });
            }
            
            renderKeranjang();
            select.selectedIndex = 0;
            document.getElementById('jumlah-input').value = '1';
        }

        function hapusBarang(index) {
            keranjang.splice(index, 1);
            renderKeranjang();
        }

        function kosongkanKeranjang() {
            if (keranjang.length === 0) return;
            
            Swal.fire({
                title: 'Kosongkan Keranjang?',
                text: "Semua item dalam keranjang akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2c5c1f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kosongkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    keranjang = [];
                    renderKeranjang();
                    Swal.fire({
                        icon: 'success',
                        title: 'Dikosongkan!',
                        text: 'Keranjang berhasil dikosongkan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        function renderKeranjang() {
            const tbody = document.querySelector('#keranjang tbody');
            tbody.innerHTML = '';
            let total = 0;

            keranjang.forEach((item, index) => {
                total += item.subtotal;
                tbody.innerHTML += `
                    <tr>
                        <td>${item.nama}</td>
                        <td>${item.jumlah}</td>
                        <td>Rp${item.harga.toLocaleString('id-ID')}</td>
                        <td>Rp${item.subtotal.toLocaleString('id-ID')}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger" onclick="hapusBarang(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('total-display').innerText = `Total: Rp${total.toLocaleString('id-ID')}`;
        }

        function submitTransaksi() {
        const kartuId = document.getElementById('kartu-id').value.trim();
        const pin = document.getElementById('pin').value.trim();

        if (!kartuId || !pin) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap',
                text: 'ID Kartu dan PIN harus diisi!'
            });
            return;
        }

        if (keranjang.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Keranjang Kosong',
                text: 'Tambahkan minimal satu item ke keranjang!'
            });
            return;
        }

        // Tampilkan loading
        Swal.fire({
            title: 'Memproses Transaksi',
            text: 'Sedang memproses transaksi, harap tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Format data untuk dikirim
        const items = keranjang.map(item => ({
            id: item.id,
            nama: item.nama,
            jumlah: item.jumlah,
            harga: item.harga
        }));

        // Kirim request ke server
        fetch('{{ route('kasir.transaksi') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                no_kartu: kartuId,
                pin: pin,
                items: items
            })
        })
        .then(async response => {
            const data = await response.json();
            
            if (!response.ok) {
                // Jika response tidak OK, lempar error dengan informasi dari server
                throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
            }
            
            return data;
        })
        .then(data => {
            Swal.close();
            
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                });

                // Reset form
                keranjang = [];
                renderKeranjang();
                document.getElementById('transaksi-form').reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat memproses transaksi.',
                    confirmButtonColor: '#28a745'
                });
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                confirmButtonColor: '#28a745'
            });
        });
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>