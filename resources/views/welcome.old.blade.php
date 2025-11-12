<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konversi Baju</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
        }
        body {
            background-color: var(--light-bg);
            color: #1e293b;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding-bottom: 2rem;
        }
        .header {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 8px;
        }
        .card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: none;
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: var(--card-bg);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header h2 {
            margin: 0;
            font-size: 1.1rem;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .btn-outline-secondary {
            border-color: var(--border-color);
            color: #64748b;
        }
        .alert {
            border-radius: 6px;
        }
        .stok-item, .conversion-rule {
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        .stok-item:last-child, .conversion-rule:last-child {
            border-bottom: none;
        }
        .stok-value {
            font-weight: 600;
            color: var(--primary);
        }
        .add-form {
            background-color: #f1f5f9;
            padding: 1.25rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .atribut-needed {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 0.5rem;
            display: none;
        }
        .atribut-needed ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0">Konversi Baju</h1>
                    <p class="text-muted mb-0">Satu halaman untuk kelola stok, konversi, dan produksi</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal:</strong> {{ $errors->first('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- 1. Stock Product -->
        <div class="card">
            <div class="card-header">
                <h2>Stock Product</h2>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#addProdukForm">
                    + Tambah Product
                </button>
            </div>
            <div class="card-body">
                @if($products->isEmpty())
                    <p class="text-muted">Belum ada produk.</p>
                @else
                    @foreach($products as $p)
                        <div class="stok-item">
                            <span>{{ $p->nama_produk }}</span>
                            <span class="stok-value">{{ $p->stok }}</span>
                        </div>
                    @endforeach
                @endif

                <div class="collapse mt-3" id="addProdukForm">
                    <div class="add-form">
                        <h5>Tambah Produk Baru</h5>
                        <form method="POST" action="{{ route('produk.store') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="nama_produk" class="form-control" placeholder="Nama produk" required>
                            </div>
                            <div class="mb-2">
                                <input type="number" name="stok_awal" class="form-control" placeholder="Stok awal (opsional)" min="0">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Stock Atribut -->
        <div class="card">
            <div class="card-header">
                <h2>Stock Atribut</h2>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#addBahanForm">
                    + Tambah Atribut
                </button>
            </div>
            <div class="card-body">
                @if($bahanList->isEmpty())
                    <p class="text-muted">Belum ada atribut.</p>
                @else
                    @foreach($bahanList as $b)
                        <div class="stok-item">
                            <span>{{ $b->nama_bahan }}</span>
                            <span class="stok-value">{{ $b->stok }}</span>
                        </div>
                    @endforeach
                @endif

                <div class="collapse mt-3" id="addBahanForm">
                    <div class="add-form">
                        <h5>Tambah Atribut Baru</h5>
                        <form method="POST" action="{{ route('bahan.store') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="nama_bahan" class="form-control" placeholder="Nama atribut (kain, kancing, benang, dll)" required>
                            </div>
                            <div class="mb-2">
                                <input type="number" name="stok_awal" class="form-control" placeholder="Stok awal (opsional)" min="0">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Konversi -->
        <div class="card">
            <div class="card-header">
                <h2>Konversi</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('konversi.proses') }}">
                    @csrf

                    <!-- Pencarian Produk -->
                    <div class="mb-3">
                        <label class="form-label">Cari Produk</label>
                        <select name="produk_id" class="form-select" required onchange="showAtribut(this)">
                            <option value="">-- Pilih produk --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-atribut='@json($p->konversi->pluck("bahan.nama_bahan")->toArray())'>
                                    {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tampilkan Atribut yang Dibutuhkan -->
                    <div id="atribut-needed" class="atribut-needed">
                        <strong>Atribut yang dibutuhkan:</strong>
                        <ul id="atribut-list"></ul>
                    </div>

                    <!-- Input Jumlah -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah yang akan dibuat</label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showAtribut(select) {
            const selected = select.options[select.selectedIndex];
            const atribut = JSON.parse(selected.dataset.atribut || '[]');
            const list = document.getElementById('atribut-list');
            const container = document.getElementById('atribut-needed');

            if (atribut.length > 0) {
                list.innerHTML = atribut.map(a => `<li>${a}</li>`).join('');
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Tampilkan atribut saat halaman pertama kali dimuat jika ada produk dipilih
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.querySelector('select[name="produk_id"]');
            if (select.value) {
                showAtribut(select);
            }
        });
    </script>
</body>
</html>