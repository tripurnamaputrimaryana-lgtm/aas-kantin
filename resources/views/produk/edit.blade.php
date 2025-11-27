@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Edit Produk</h2>
    </div>
        <div class="card-body">
            <form action="{{ route('produk.update',$produk->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-primary">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Harga</label>
                    <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('produk.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
