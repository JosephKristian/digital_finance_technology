@extends('layouts.sb-admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="mt-4 display-4">Selamat Datang di Aplikasi Digital Finance!</h1>
        <p class="lead">
            Kami sangat senang Anda bergabung dengan kami! Aplikasi Digital Finance dirancang khusus untuk membantu pengusaha UMKM seperti Anda dalam mengelola keuangan dengan lebih efisien dan efektif. Dengan fitur-fitur yang kami tawarkan, Anda dapat menyusun dan mengevaluasi keuangan usaha Anda dengan mudah.
        </p>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="h5">Mengapa Memilih Aplikasi Kami?</h2>
        </div>
        <div class="card-body">
            <p>
                Di era digital ini, pengelolaan keuangan yang baik adalah kunci untuk kesuksesan usaha. Aplikasi kami memberikan Anda alat yang diperlukan untuk:
            </p>
            <ul class="list-group">
                <li class="list-group-item"><strong>Menyusun Keuangan:</strong> Dengan fitur registrasi UMKM dan pengelolaan master data, Anda dapat dengan mudah mengatur semua informasi penting dalam satu tempat.</li>
                <li class="list-group-item"><strong>Memantau Transaksi:</strong> Catat setiap transaksi penjualan, penerimaan, dan pengeluaran kas dengan mudah, sehingga Anda selalu tahu posisi keuangan usaha Anda.</li>
                <li class="list-group-item"><strong>Membuat Laporan Keuangan:</strong> Dapatkan laporan yang komprehensif seperti laporan laba rugi, arus kas, dan evaluasi keuangan untuk membantu Anda mengambil keputusan yang lebih baik.</li>
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="h5">Fitur Unggulan Kami</h2>
        </div>
        <div class="card-body">
            <p>Berikut adalah beberapa fitur unggulan yang akan Anda nikmati:</p>
            <ol class="list-group">
                <li class="list-group-item">Registrasi UMKM yang mudah dan cepat.</li>
                <li class="list-group-item">Dashboard admin untuk memantau dan menyetujui registrasi UMKM.</li>
                <li class="list-group-item">Pengelolaan data produk dan pelanggan yang efisien.</li>
                <li class="list-group-item">Catatan akuntansi yang terstruktur dengan baik.</li>
                <li class="list-group-item">Laporan keuangan yang lengkap dan mudah dipahami.</li>
            </ol>
        </div>
    </div>

    <div class="text-center mb-4">
        <h2 class="h5">Mari Mulai Perjalanan Keuangan Anda!</h2>
        <p>
            Kami percaya bahwa dengan aplikasi ini, Anda akan dapat mengelola keuangan usaha Anda dengan lebih baik, sehingga Anda dapat fokus pada pengembangan bisnis Anda. Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim dukungan kami.
        </p>
        <p class="lead">
            Selamat beraktivitas dan semoga sukses selalu menyertai usaha Anda!
        </p>
    </div>
</div>
@endsection