@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">📑 Daftar Transaksi</h2>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Metode</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td>{{ $t->kode_transaksi }}</td>
                        <td>{{ $t->tanggal }}</td>
                        <td>Rp {{ number_format($t->total,0,',','.') }}</td>
                        <td>Rp {{ number_format($t->bayar,0,',','.') }}</td>
                        <td>Rp {{ number_format($t->kembalian,0,',','.') }}</td>
                        <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                        <td class="text-center">
                            <a href="{{ route('transaksi.show',$t->id) }}" class="btn btn-info btn-sm fw-bold">
                                <i class="bi bi-eye"></i> Show
                            </a>
                            <a href="{{ route('transaksi.edit',$t->id) }}" class="btn btn-warning btn-sm fw-bold">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('transaksi.destroy',$t->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Yakin hapus transaksi ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
