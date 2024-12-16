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
                Halaman ini berisi daftar Umkm untuk pengelolaan <b>{{ Auth::user()->name }}</b>. Anda dapat menambah, mengedit,
                atau menghapus atau mengapprove berkas data umkm sesuai kebutuhan.
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Daftar Pelanggan

            </div>
            <div class="card-body">
                @include('admin.umkms.partials.tabel')
            </div>
        </div>
    </div>

    
@endsection
