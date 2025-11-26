@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Tambah Produk Kantin</h2>
        </a>
    </div>
        <div class="card-body">
            <form action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-primary">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <button href="{{ route('produk.index') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-pencil-square"></i> Simpan
                </button>
                <a href="{{ route('produk.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
