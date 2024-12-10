@extends('layouts.sb-admin')

@section('title', 'Laporan Neraca')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Neraca</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Neraca</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt me-1"></i> Laporan Neraca
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Total Aset</th>
                    <td>Rp {{ number_format($assets, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Liabilitas</th>
                    <td>Rp {{ number_format($liabilities, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Ekuitas</th>
                    <td>Rp {{ number_format($equity, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
