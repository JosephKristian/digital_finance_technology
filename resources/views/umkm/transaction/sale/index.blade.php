@extends('layouts.sb-admin')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Transaksi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"data-bs-toggle="collapse" data-bs-target="#transaksiSideBar">Transaksi</a></li>
            <li class="breadcrumb-item active">Penjualan</li>
        </ol>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid px-4">

            <!-- Row untuk Card Tambah Penjualan dan Tambah Detail Penjualan -->
            <div class="row">
                @include('umkm.transaction.sale.partials.add_sale_card')
            </div>

            <!-- Card untuk Detail Penjualan -->
            <div class="card mt-4">
                @include('umkm.transaction.sale.partials.detail_sale_card')
            </div>
        </div>

        @include('umkm.customers.partials.create_modal')

    @endsection

    @section('script')
        <script>
            // Inisialisasi DataTable
            document.addEventListener('DOMContentLoaded', function() {
                const dataTable = new simpleDatatables.DataTable('#dataTable');
                const productTable = new simpleDatatables.DataTable('#productTable');
            });
            // Pilih metode pembayaran dan simpan id-nya
            document.querySelectorAll('.payment-method').forEach(function(methodBox) {
                methodBox.addEventListener('click', function() {
                    // Menandai metode pembayaran yang dipilih
                    document.querySelectorAll('.payment-method').forEach(function(box) {
                        box.style.backgroundColor = ''; // Reset warna latar
                    });
                    this.style.backgroundColor = '#f0f0f0'; // Tandai dengan warna latar
                    const paymentMethodId = this.getAttribute('data-method-id');
                    document.getElementById('payment_method_id').value =
                        paymentMethodId; // Isi input hidden dengan id metode pembayaran
                });
            });

            // Handle submit form setelah konfirmasi pembayaran
            document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
                const paymentMethodId = document.getElementById('payment_method_id').value;
                if (!paymentMethodId) {
                    alert('Silakan pilih metode pembayaran terlebih dahulu!');
                    return;
                }

                // Submit form jika sudah memilih metode pembayaran
                document.getElementById('completeTransactionForm').submit();
            });
        </script>


        <script>
            $(document).ready(function() {
                // Inisialisasi Select2 pada elemen <select> untuk pencarian
                $('#customer_id').select2({
                    placeholder: "Cari Nama Pelanggan",
                    allowClear: true
                });

                $('#product_id').select2({
                    placeholder: "Cari Nama Produk",
                    allowClear: true
                });

                // Memeriksa status accordion dari localStorage
                const accordionStatus = localStorage.getItem('accordionStatus');

                if (accordionStatus === 'open') {
                    // Jika status sebelumnya adalah terbuka, buka accordion
                    $('#addSalesAccordion').collapse('show');
                } else {
                    // Jika tidak, pastikan accordion tertutup
                    $('#addSalesAccordion').collapse('hide');
                }

                // Menyimpan status accordion ke localStorage ketika status berubah
                $('#addSales').on('show.bs.collapse', function() {
                    localStorage.setItem('accordionStatus', 'open');
                });

                $('#addSales').on('hide.bs.collapse', function() {
                    localStorage.setItem('accordionStatus', 'closed');
                });

                // Pastikan jQuery dan Bootstrap JS sudah dimuat
                $('#openPaymentModal').on('click', function() {
                    $('#paymentModal').modal('show'); // Menampilkan modal dengan ID "paymentModal"
                });

            


            });
        </script>
    @endsection
