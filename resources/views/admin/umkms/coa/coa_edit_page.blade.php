@extends('layouts.sb-admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Chart of Account</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('super-admin.coa.index', $coa->umkm_id) }}">COA UMKM</a></li>
        <li class="breadcrumb-item active">Edit COA</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Formulir Edit Chart of Account
        </div>
        <div class="card-body">
            <form action="{{ route('super-admin.coa.update', [$coa->umkm_id, $coa->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Kode Akun -->
                <div class="mb-3">
                    <label for="account_code" class="form-label">Kode Akun</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="account_code" 
                        name="account_code" 
                        value="{{ old('account_code', $coa->account_code) }}" 
                        required 
                        readonly 
                        style="background-color: #f0f0f0; color: #6c757d; cursor: not-allowed; opacity: 0.7;"
                    >
                </div>

                <!-- Nama Akun -->
                <div class="mb-3">
                    <label for="account_name" class="form-label">Nama Akun</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="account_name" 
                        name="account_name" 
                        value="{{ old('account_name', $coa->account_name) }}" 
                        required
                    >
                </div>

                <!-- Parent Akun -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Akun (Jika Ada)</label>
                    <select class="form-select" id="parent_id" name="parent_id">
                        <option value="">Pilih Parent Akun (Opsional)</option>
                        @foreach ($parentCoas as $parent)
                            <option value="{{ $parent->id }}" {{ $coa->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->account_code }} - {{ $parent->account_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category">
                        <option value="current" {{ $coa->category === 'current' ? 'selected' : '' }}>Current</option>
                        <option value="non_current" {{ $coa->category === 'non_current' ? 'selected' : '' }}>Non-Current</option>
                    </select>
                </div>

                <!-- Status Aktif -->
                <div class="mb-3">
                    <label for="is_active" class="form-label">Aktif</label>
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            value="1" 
                            id="is_active" 
                            name="is_active" 
                            {{ $coa->is_active ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Akun ini aktif
                        </label>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('super-admin.coa.index', $coa->umkm_id) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
