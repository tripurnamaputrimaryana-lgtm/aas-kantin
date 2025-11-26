<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model 
{

    use HasFactory;

    protected $table = 'produk';
    protected $fillable = ['nama_produk','harga','stok','kategori_id'];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksiDetails() {
        return $this->hasMany(TransaksiDetail::class);
    }
}

