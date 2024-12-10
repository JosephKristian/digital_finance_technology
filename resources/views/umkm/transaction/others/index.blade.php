@extends('layouts.sb-admin')

@section('title', 'Transaksi lain - lain')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Transaksi Lain - lain</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"data-bs-toggle="collapse"
                    data-bs-target="#transaksiSideBar">Transaksi</a></li>
            <li class="breadcrumb-item active">Lain - lain</li>
        </ol>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid px-4">
            <form action="{{ route('other.transactions.create') }}" method="POST">
                @csrf
                <!-- Tanggal Transaksi -->
                <div class="mb-3">
                    <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" value = "{{ date('Y-m-d') }}" class="form-control" id="tanggalTransaksi"
                        name="tanggalTransaksi">
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option value="income">Penerimaan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>


                <!-- Nama Transaksi -->
                <div class="mb-3">
                    <label for="namaTransaksi" class="form-label">Nama Transaksi</label>
                    <select class="form-select" id="namaTransaksi" name="namaTransaksi">
                        <!-- Opsi transaksi akan diubah berdasarkan kategori -->
                    </select>
                </div>

                <!-- Nominal -->
                <div class="mb-3">
                    <label for="nominal" class="form-label">Nominal</label>
                    <input type="number" class="form-control" id="nominal" name="nominal"
                        placeholder="Masukkan nominal transaksi">
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                        placeholder="Masukkan keterangan transaksi"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </form>
        </div>



    @endsection

    @section('script')
        <script>
            // Ambil elemen DOM
            const kategoriSelect = document.getElementById('kategori');
            const namaTransaksiSelect = document.getElementById('namaTransaksi');

            // Data COA untuk income dan expense
            const incomeOptions = @json($incomeOptions);
            const expenseOptions = @json($expenseOptions);

            // Fungsi untuk memperbarui opsi nama transaksi
            function updateTransactionOptions(category) {
                let options = [];

                if (category === 'income') {
                    options = incomeOptions;
                } else if (category === 'expense') {
                    options = expenseOptions;
                }

                // Kosongkan opsi nama transaksi
                namaTransaksiSelect.innerHTML = '';

                // Tambahkan opsi baru berdasarkan kategori yang dipilih
                for (const [id, accountName] of Object.entries(options)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = accountName;
                    namaTransaksiSelect.appendChild(option);
                }
            }

            // Atur opsi nama transaksi saat kategori berubah
            kategoriSelect.addEventListener('change', function() {
                updateTransactionOptions(this.value);
            });

            // Inisialisasi dengan kategori yang dipilih saat ini
            updateTransactionOptions(kategoriSelect.value);
        </script>
    @endsection
