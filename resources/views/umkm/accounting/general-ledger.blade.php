@extends('layouts.sb-admin')

@section('title', 'Jurnal Umum')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan Penerimaan Kas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Penerimaan Kas</li>
        </ol>

        <!-- Form Pilihan Bulan dan Tahun -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('accounting.general-ledger') }}" id="gl-form">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="month">Bulan:</label>
                            <select name="month" id="month" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year">Tahun:</label>
                            <select name="year" id="year" class="form-control">
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- Laporan Penerimaan Kas -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="text-center w-100">
                    <h5 class="mb-0">Telkom University</h5>
                    <h5 class="mb-0">JURNAL UMUM</h5>
                    <h5 class="mb-0">Periode {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</h5>
                </div>

            </div>

            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <form action="{{ route('print.pdf.general.ledger') }}" method="POST" target="_blank" class="d-inline">
                        @csrf
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="generalLedger" value="{{ json_encode($generalLedger) }}">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fas fa-file-pdf me-1"></i> Print PDF
                        </button>
                    </form>                    
                    <a id="onDev" class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-1"></i> Print Excel
                    </a>
                </div>
                @include('umkm.accounting.partials.general-ledger_tabel')
            </div>


        </div>
    </div>
@endsection

@section('script')
<script>
    // Menangkap elemen form dan dropdown bulan/tahun
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('gl-form');
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');

        // Tambahkan event listener untuk dropdown bulan
        monthSelect.addEventListener('change', function() {
            console.log("Bulan yang dipilih:", monthSelect.value); // Log bulan yang dipilih
            form.submit();
        });

        // Tambahkan event listener untuk dropdown tahun
        yearSelect.addEventListener('change', function() {
            console.log("Tahun yang dipilih:", yearSelect.value); // Log tahun yang dipilih
            form.submit();
        });

        console.log("Form report ditemukan:", form !== null);
        console.log("Dropdown bulan ditemukan:", monthSelect !== null);
        console.log("Dropdown tahun ditemukan:", yearSelect !== null);
    });
</script>
@endsection
