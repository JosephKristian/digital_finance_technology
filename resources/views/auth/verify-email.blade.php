@extends('layouts.sb-admin')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="mt-4 display-4">Verifikasi Email Anda</h1>
        <p class="lead">
            Terima kasih telah mendaftar! Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan ke email Anda. Jika Anda belum menerima email, kami dengan senang hati akan mengirimkan ulang.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="h5">Lakukan Verifikasi Sekarang</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
        </div>
    </div>

    <div class="text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
