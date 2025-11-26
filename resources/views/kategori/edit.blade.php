@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Edit Kategori Produk</h2>
        </a>
    </div>
        <div class="card-body">
            <form action="{{ route('kategori.update',$kategori->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-primary">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" 
                           value="{{ $kategori->nama_kategori }}" required>
                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-pencil-square"></i> Update
                </a>
                <a href="{{ route('kategori.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
