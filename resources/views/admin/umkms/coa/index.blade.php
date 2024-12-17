@extends('layouts.sb-admin')

@section('title', 'Daftar COA')

@section('content')
<div class="container mt-4">
    <h3>Daftar Chart of Account (COA) - {{ $umkm->name }}</h3>

    <a href="{{ route('super-admin.coa.create', $umkm->id) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah COA
    </a>

    @include('admin.umkms.coa.partials.coa-table')
</div>
@endsection
