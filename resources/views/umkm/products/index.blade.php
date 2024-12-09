@extends('layouts.sb-admin')

@section('title', 'Master Data Produk')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Master Data Produk</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Master Data Produk</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                Halaman ini berisi daftar Produk untuk UMKM <b>{{ $umkm->name }}</b>. Anda dapat menambah, mengedit,
                atau menghapus data Produk sesuai kebutuhan.
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Daftar Produk
                <a href="#" class="btn btn-sm btn-success float-end" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>
            <div class="card-body">
                @include('umkm.products.partials.tabel')
            </div>
        </div>
    </div>

    @include('umkm.products.partials.create_modal')
@endsection
