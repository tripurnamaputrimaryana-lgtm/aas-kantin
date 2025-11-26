@extends('layouts.dashboard')

@section('content')

<style>
    .welcome-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        box-sizing: border-box;
    }

    .welcome-card .icon-bg {
        position: absolute;
        right: 30px;
        bottom: 30px;
        font-size: 180px;
        opacity: 0.13;
        user-select: none;
        pointer-events: none;
    }

    .welcome-card h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .welcome-card p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
    }

    .welcome-card .btn {
        font-size: 1.1rem;
        padding: 12px 30px;
    }

</style>

<div class="content-wrapper welcome-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y d-flex justify-content-center align-items-center">

    <div class="welcome-card">

        <i class="bx bx-restaurant icon-bg"></i>

        <h1>Selamat Datang di Kantin Sekolah</h1>
        <h1>SMK ASSALAAM BANDUNG</h1>

        <p>
            Kelola produk, transaksi, dan fitur lainnya melalui menu di sebelah kiri.
        </p>

        <a href="{{ route('produk.index') }}" class="btn btn-light btn-lg shadow-sm">
            Mulai Kelola Produk
            <i class="bx bx-right-arrow-alt ms-1"></i>
        </a>

    </div>

  </div>
</div>

@endsection
