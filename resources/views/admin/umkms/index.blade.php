@extends('layouts.sb-admin')

@section('title', 'Master Data Pelanggan')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Halaman -->
        <h1 class="mt-4">Master Data Pelanggan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Master Data UMKM</li>
        </ol>

        <!-- Informasi Halaman -->
        <div class="card mb-4">
            <div class="card-body">
                Halaman ini berisi daftar UMKM untuk pengelolaan <b>{{ Auth::user()->name }}</b>. 
                Anda dapat menambah, mengedit, menghapus, atau meng-approve berkas data UMKM sesuai kebutuhan.
            </div>
        </div>

        <!-- Tabel Daftar UMKM -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i> Daftar UMKM
                </div>
            </div>
            <div class="card-body">
                @include('admin.umkms.partials.tabel')
            </div>
        </div>

        <!-- Tabel Token UMKM -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-key me-1"></i> Token UMKM
                </div>
            </div>
            <div class="card-body">
                <!-- Tombol Buat Token -->
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTokenModal">
                        <i class="fas fa-plus me-1"></i> Buat Token Baru
                    </button>
                </div>
                @include('admin.umkms.partials.tabel-2')
            </div>
        </div>
    </div>

    <!-- Modal Partials -->
    @include('admin.umkms.partials.token_modal')
    @include('admin.umkms.partials.approve_modal')
    @include('admin.umkms.partials.edit_modal')
    @include('admin.umkms.partials.delete_modal')
@endsection

@section('script')
    <script>
        // Fungsi untuk menyalin token ke clipboard
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId);
            copyText.select();
            document.execCommand("copy");
            alert("Token berhasil disalin: " + copyText.value);
        }
    </script>
@endsection
