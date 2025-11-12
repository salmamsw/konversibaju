<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Konversi Baju 🎽</title>

  <!-- ✅ Perbaiki: hapus spasi di akhir URL -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e40af;
      --bg: #f3f4f6;
      --card-bg: #ffffff;
      --border-color: #e5e7eb;
      --text-dark: #1f2937;
      --text-muted: #6b7280;
      --radius: 14px;
      --shadow-soft: 0 4px 10px rgba(0, 0, 0, 0.04);
    }

    body {
      background: var(--bg);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      font-size: 0.95rem;
      padding-bottom: 3rem;
    }

    .header {
      background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
      color: #fff;
      border-radius: var(--radius);
      padding: 2rem 1.5rem;
      margin-top: 2rem;
      margin-bottom: 2.5rem;
      box-shadow: var(--shadow-soft);
    }

    .header h1 {
      font-weight: 600;
      font-size: 1.75rem;
      letter-spacing: -0.02em;
    }

    .card {
      border: none;
      border-radius: var(--radius);
      background-color: var(--card-bg);
      box-shadow: var(--shadow-soft);
    }

    .card-header {
      background: transparent;
      border-bottom: 1px solid var(--border-color);
      padding: 1rem 1.25rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .card-header h2 {
      font-size: 1.1rem;
      font-weight: 600;
      margin: 0;
    }

    .stok-item {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 0;
      border-bottom: 1px solid var(--border-color);
    }

    .stok-item:last-child {
      border-bottom: none;
    }

    .stok-value {
      color: var(--primary);
      font-weight: 600;
    }

    .btn-outline-secondary {
      border-color: var(--border-color);
      color: var(--text-muted);
      border-radius: 8px;
    }

    .alert {
      border-radius: var(--radius);
      box-shadow: var(--shadow-soft);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header text-center">
      <h1>Konversi Baju 🎽</h1>
      <p>Kelola stok, atribut, dan proses konversi produk dengan mudah</p>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ⚠️ <strong>Gagal:</strong> {{ $errors->first('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✨ <strong>Berhasil:</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- STOCK PRODUCT -->
    <div class="card mb-4">
      <div class="card-header">
        <h2>📦 Stock Product</h2>
        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#addProdukForm">➕ Tambah Product</button>
      </div>
      <div class="card-body">
        @if($products->isEmpty())
          <p class="text-muted">Belum ada produk.</p>
        @else
          @foreach($products as $p)
            <div class="stok-item">
              <div>
                <span>{{ $p->nama_produk }}</span>
                <span class="stok-value ms-2">{{ $p->stok }}</span>
              </div>
              <div>
                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editProdukModal{{ $p->id }}">✏️</button>
                <form class="d-inline" method="POST" action="{{ route('produk.destroy', $p->id) }}" onsubmit="return confirm('Yakin hapus {{ $p->nama_produk }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                </form>
              </div>
            </div>
          @endforeach
        @endif

        <div class="collapse mt-3" id="addProdukForm">
          <div class="add-form">
            <h5 class="fw-semibold mb-3">🆕 Tambah Produk Baru</h5>
            <form method="POST" action="{{ route('produk.store') }}">
              @csrf
              <div class="mb-3">
                <input type="text" name="nama_produk" class="form-control" placeholder="Nama produk" required>
              </div>
              <div class="mb-3">
                <input type="number" name="stok_awal" class="form-control" placeholder="Stok awal (opsional)" min="0">
              </div>
              <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- STOCK ATRIBUT -->
    <div class="card mb-4">
      <div class="card-header">
        <h2>🧵 Stock Atribut</h2>
        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#addBahanForm">➕ Tambah Atribut</button>
      </div>
      <div class="card-body">
        @if($bahanList->isEmpty())
          <p class="text-muted">Belum ada atribut.</p>
        @else
          @foreach($bahanList as $b)
            <div class="stok-item">
              <div>
                <span>{{ $b->nama_bahan }}</span>
                <span class="stok-value ms-2">{{ $b->stok }} {{ $b->satuan }}</span>
              </div>
              <div>
                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editBahanModal{{ $b->id }}">✏️</button>
                <form class="d-inline" method="POST" action="{{ route('bahan.destroy', $b->id) }}" onsubmit="return confirm('Yakin hapus {{ $b->nama_bahan }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                </form>
              </div>
            </div>
          @endforeach
        @endif

        <div class="collapse mt-3" id="addBahanForm">
          <div class="add-form">
            <h5 class="fw-semibold mb-3">🧶 Tambah Atribut Baru</h5>
            <form method="POST" action="{{ route('bahan.store') }}">
              @csrf
              <div class="mb-3">
                <input type="text" name="nama_bahan" class="form-control" placeholder="Nama atribut (kain, kancing, benang, dll)" required>
              </div>
              <div class="mb-3">
                <input type="number" name="stok_awal" class="form-control" placeholder="Stok awal (opsional)" min="0">
              </div>
              <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- KONVERSI -->
    <div class="card">
      <div class="card-header">
        <h2>🔁 Konversi Manual</h2>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('konversi.proses') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Pilih Produk 🔍</label>
            <select name="produk_id" class="form-select" required>
              <option value="">-- Pilih produk --</option>
              @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->nama_produk }} (Stok: {{ $p->stok }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah yang akan dibuat 🧮</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
            <div class="form-text">Jumlah unit produk yang ingin diproduksi.</div>
          </div>
          <div class="mb-4">
            <label class="form-label">Isi Kebutuhan Bahan 🧵</label>
            <div class="row g-3">
              @foreach($bahanList as $b)
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-text" style="min-width: 200px; text-align: left; white-space: nowrap;">
                      {{ $b->nama_bahan }} ({{ $b->satuan }})
                    </span>
                    <input type="number" name="atribut[{{ $b->id }}]" class="form-control" min="0" step="0.1" value="0">
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ✅ MODAL DIPINDAH KE LUAR CARD, DI AKHIR BODY -->
  @foreach($products as $p)
    <div class="modal fade" id="editProdukModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('produk.update', $p->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ $p->nama_produk }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $p->stok }}" min="0" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  @foreach($bahanList as $b)
    <div class="modal fade" id="editBahanModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Atribut</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('bahan.update', $b->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <input type="text" name="nama_bahan" class="form-control" value="{{ $b->nama_bahan }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $b->stok }}" min="0" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" class="form-control" value="{{ $b->satuan }}" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  <!-- ✅ Perbaiki: hapus spasi di akhir URL -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>