@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Tambah Kategori Produk</h2>
        </a>
    </div>
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-primary">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>
                <button href="{{ route('kategori.index') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-pencil-square"></i> Simpan
                </button>
                <a href="{{ route('kategori.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
