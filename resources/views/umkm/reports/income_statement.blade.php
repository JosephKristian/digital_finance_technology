@extends('layouts.sb-admin')

@section('title', 'Laporan Laba Rugi')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Laba Rugi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Laba Rugi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt me-1"></i> Laporan Laba Rugi
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Total Pendapatan</th>
                    <td>Rp {{ number_format($income, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Beban</th>
                    <td>Rp {{ number_format($expenses, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Laba Bersih</th>
                    <td>Rp {{ number_format($netProfit, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
