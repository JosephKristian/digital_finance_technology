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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createTokenModal">
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
        const expiresAtInput = document.getElementById('expires_at');
        const errorMessage = document.getElementById('error-message');
        const form = document.querySelector('#createTokenModal form');
        let isValid = false;

        function validateExpiresAt() {
            const input = expiresAtInput.value;

            // Pastikan input diisi
            if (!input) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Masa berlaku harus diisi.';
                isValid = false;
                return;
            }

            const selectedDate = new Date(input);
            const now = new Date();

            // Pastikan input berupa tanggal yang valid
            if (isNaN(selectedDate)) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Masa berlaku harus berupa tanggal yang valid.';
                isValid = false;
                return;
            }

            // Pastikan tanggal lebih dari waktu saat ini
            if (selectedDate <= now) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Masa berlaku harus lebih dari waktu saat ini.';
                isValid = false;
                return;
            }

            // Jika validasi lolos
            errorMessage.style.display = 'none';
            isValid = true;
        }

        // Event listener untuk validasi input
        expiresAtInput.addEventListener('input', validateExpiresAt);

        // Event listener untuk mencegah pengiriman formulir jika tidak valid
        form.addEventListener('submit', function(e) {
            validateExpiresAt(); // Pastikan validasi dijalankan sebelum submit
            if (!isValid) {
                e.preventDefault(); // Cegah pengiriman formulir jika tidak valid
            }
        });
    </script>

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
