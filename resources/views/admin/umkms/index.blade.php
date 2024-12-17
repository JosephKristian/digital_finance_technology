@extends('layouts.sb-admin')

@section('title', 'Master Data Pelanggan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Master Data Pelanggan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Master Data Umkm</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                Halaman ini berisi daftar Umkm untuk pengelolaan <b>{{ Auth::user()->name }}</b>. Anda dapat menambah,
                mengedit,
                atau menghapus atau mengapprove berkas data umkm sesuai kebutuhan.
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Daftar Umkm

            </div>
            <div class="card-body">
                @include('admin.umkms.partials.tabel')
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Token UMKM

            </div>
            <div class="card-body">
                <!-- Button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTokenModal">
                    Buat Token Baru
                </button>
                @include('admin.umkms.partials.tabel-2')
            </div>
        </div>
    </div>

    @include('admin.umkms.partials.token_modal')
    @include('admin.umkms.partials.approve_modal')
    @include('admin.umkms.partials.edit_modal')
    @include('admin.umkms.partials.delete_modal')

@endsection

@section('script')
    <script>
        function copyToClipboard(elementId) {
            // Ambil elemen input berdasarkan ID
            const inputElement = document.getElementById(elementId);

            // Pilih teks dalam input field
            inputElement.select();
            inputElement.setSelectionRange(0, 99999); // Untuk browser lama

            // Salin teks ke clipboard
            navigator.clipboard.writeText(inputElement.value)
                .then(() => {
                    alert("Copied to clipboard: " + inputElement.value); // Notifikasi berhasil
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        }
    </script>

@endsection
