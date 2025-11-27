@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary mb-4">Tambah Transaksi</h2>

    <form id="form-transaksi" action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label text-primary">Kode Transaksi</label>
            <input type="text" name="kode_transaksi" class="form-control" value="TRX{{ time() }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label text-primary">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <h5 class="fw-bold text-primary mt-4">Detail Produk</h5>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Pilih</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $p)
                <tr>
                    <td><input type="checkbox" name="produk_id[]" value="{{ $p->id }}" class="produk-check"></td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>
                        <span class="harga" data-harga="{{ $p->harga }}">
                            Rp {{ number_format($p->harga,0,',','.') }}
                        </span>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1"></td>
                    <td><span class="subtotal">Rp 0</span></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th><span id="total">Rp 0</span></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Kembalian</th>
                    <th><span id="kembalian">Rp 0</span></th>
                </tr>
            </tfoot>
        </table>

        <div class="mb-3">
            <label class="form-label text-primary">Metode Pembayaran</label>
            <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="debit">Debit</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label text-primary">Nominal Bayar</label>
            <input type="number" id="bayar" name="bayar" class="form-control" placeholder="Masukkan nominal bayar" required>
        </div>

        <div class="mb-3" id="password-wrapper" style="display:none;">
            <label class="form-label text-primary">Password (hanya untuk debit)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password debit">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

{{-- Script untuk hitung subtotal, total & validasi pembayaran --}}
<script>
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let checkbox = row.querySelector('.produk-check');
            let harga = parseInt(row.querySelector('.harga').dataset.harga);
            let jumlah = parseInt(row.querySelector('.jumlah').value);
            let subtotalCell = row.querySelector('.subtotal');

            if (checkbox.checked) {
                let subtotal = harga * jumlah;
                subtotalCell.textContent = formatRupiah(subtotal);
                total += subtotal;
            } else {
                subtotalCell.textContent = 'Rp 0';
            }
        });
        document.getElementById('total').textContent = formatRupiah(total);

        let bayar = parseInt(document.getElementById('bayar').value) || 0;
        let metode = document.getElementById('metode_pembayaran').value;
        let kembalian = 0;

        if (metode === 'cash') {
            kembalian = bayar - total;
            document.getElementById('kembalian').textContent = formatRupiah(kembalian >= 0 ? kembalian : 0);
        } else {
            document.getElementById('kembalian').textContent = 'Rp 0';
        }
    }

    // Tampilkan/sembunyikan password sesuai metode
    document.getElementById('metode_pembayaran').addEventListener('change', function() {
        if (this.value === 'debit') {
            document.getElementById('password-wrapper').style.display = 'block';
        } else {
            document.getElementById('password-wrapper').style.display = 'none';
        }
        hitungTotal();
    });

    // Validasi sebelum submit
    document.getElementById('form-transaksi').addEventListener('submit', function(e) {
        let totalText = document.getElementById('total').textContent.replace(/\D/g,'');
        let total = parseInt(totalText) || 0;
        let bayar = parseInt(document.getElementById('bayar').value) || 0;
        let metode = document.getElementById('metode_pembayaran').value;

        if (metode === 'debit') {
            if (bayar !== total) {
                e.preventDefault();
                alert('Nominal bayar untuk debit harus sama persis dengan total transaksi!');
            }
            if (!document.getElementById('password').value) {
                e.preventDefault();
                alert('Password wajib diisi untuk metode debit!');
            }
        } else if (metode === 'cash') {
            if (bayar < total) {
                e.preventDefault();
                alert('Nominal bayar cash tidak boleh kurang dari total transaksi!');
            }
        }
    });

    document.querySelectorAll('.produk-check, .jumlah, #bayar').forEach(function(el) {
        el.addEventListener('input', hitungTotal);
        el.addEventListener('change', hitungTotal);
    });
</script>
@endsection
