@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Edit Transaksi</h2>
    </div>
        <div class="card-body">
            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-primary">Kode Transaksi</label>
                    <input type="text" name="kode_transaksi" class="form-control" 
                           value="{{ $transaksi->kode_transaksi }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" 
                           value="{{ $transaksi->tanggal }}" required>
                </div>
                
                <h5 class="fw-bold text-primary mt-4">Detail Produk</h5>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Pilih</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $p)
                        @php
                            $detail = $transaksi->details->firstWhere('produk_id', $p->id);
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="produk_id[]" value="{{ $p->id }}"
                                    {{ $detail ? 'checked' : '' }}>
                            </td>
                            <td>{{ $p->nama_produk }}</td>
                            <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control" min="1"
                                    value="{{ $detail ? $detail->jumlah : '' }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="fw-bold text-primary mt-4">Pembayaran</h5>
                <div class="mb-3">
                    <label class="form-label text-primary">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-select" required>
                        <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="debit" {{ $transaksi->metode_pembayaran == 'debit' ? 'selected' : '' }}>Debit</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-primary">Nominal Bayar</label>
                    <input type="number" name="bayar" class="form-control" 
                           value="{{ $transaksi->bayar }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
