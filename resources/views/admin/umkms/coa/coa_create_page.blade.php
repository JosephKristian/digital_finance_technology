@extends('layouts.sb-admin')

@section('title', 'Buat Chart of Account')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Buat Chart of Account untuk UMKM: {{ $umkm->name }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super-admin.coa.index', $umkm->id) }}">COA UMKM</a></li>
            <li class="breadcrumb-item active">Buat COA</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus-circle me-1"></i> Formulir Buat Chart of Account
            </div>
            <div class="card-body">
                <form action="{{ route('super-admin.coa.store', $umkm->id) }}" method="POST">
                    @csrf
                    <!-- Kode Akun -->
                    <div class="mb-3">
                        <label for="account_code" class="form-label">Kode Akun</label>
                        <input type="text" class="form-control" id="account_code" name="account_code" required readonly
                            style="background-color: #f0f0f0; color: #6c757d; cursor: not-allowed; opacity: 0.7;">
                    </div>

                    <!-- Nama Akun -->
                    <div class="mb-3">
                        <label for="account_name" class="form-label">Nama Akun</label>
                        <input type="text" class="form-control" id="account_name" name="account_name" required>
                    </div>

                    <!-- Tipe COA -->
                    <div class="mb-3">
                        <label for="coa_type_id" class="form-label">Tipe COA</label>
                        <select class="form-select" id="coa_type_id" name="coa_type_id" required>
                            <option value="" disabled selected>Pilih Tipe COA</option>
                            @foreach ($coaTypes as $coaType)
                                <option value="{{ $coaType->coa_type_id }}">{{ $coaType->type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub Akun -->
                    <div class="mb-3">
                        <label for="coa_sub_id" class="form-label">Sub Akun</label>
                        <select class="form-select" id="coa_sub_id" name="coa_sub_id" required>
                            <option value="" disabled selected>Pilih Sub Akun</option>
                            <!-- Sub Akun akan dimuat setelah memilih Tipe COA -->
                        </select>
                    </div>

                    <!-- Parent Akun -->
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Akun (Jika Ada)</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="" disabled selected>Pilih Parent Akun (Opsional)</option>
                            @foreach ($parentCoas as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->account_code }} -
                                    {{ $parent->account_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="current">Current</option>
                            <option value="non_current">Non-Current</option>
                        </select>
                    </div>

                    <!-- Status Aktif -->
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Aktif</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                                checked>
                            <label class="form-check-label" for="is_active">Akun ini aktif</label>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coaTypeSelect = document.getElementById('coa_type_id');
            const coaSubSelect = document.getElementById('coa_sub_id');
            const accountCodeInput = document.getElementById('account_code');
            const umkmId = @json($umkm->id); // Mengambil ID UMKM dari server-side

            // Disable account_code field
            accountCodeInput.setAttribute('readonly', true);
            console.log("Field 'account_code' diatur ke readonly.");

            // Function untuk mengupdate COA Sub berdasarkan COA Type
            coaTypeSelect.addEventListener('change', function() {
                const coaTypeId = this.value; // Ambil nilai tipe COA yang dipilih
                console.log("COA Type ID selected:", coaTypeId);
                console.log("UMKM ID:", umkmId);

                // Kosongkan dropdown COA Sub
                coaSubSelect.innerHTML = '<option value="">Pilih Sub Akun</option>';
                console.log("Dropdown COA Sub dikosongkan.");

                if (coaTypeId) {
                    const url = `/super-admin/umkm/${umkmId}/coa/coa-sub/${coaTypeId}`;
                    console.log("Fetching data from URL:", url);

                    fetch(url)
                        .then(response => {
                            console.log("Response status:", response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Data fetched successfully:", data);
                            data.forEach(sub => {
                                console.log("Adding sub:", sub);
                                const option = document.createElement('option');
                                option.value = sub.coa_sub_id;
                                option.textContent = sub.sub_name;
                                coaSubSelect.appendChild(option);
                            });
                            console.log("Dropdown COA Sub updated.");
                        })
                        .catch(error => {
                            console.error("Error fetching COA Sub data:", error);
                        });
                } else {
                    console.log("No COA Type ID selected.");
                }
            });

            // Function untuk mengupdate account_code
            const updateAccountCode = () => {
                const coaTypeId = coaTypeSelect.value;
                const coaSubId = coaSubSelect.value;

                console.log("Update account code triggered.");
                console.log("COA Type ID:", coaTypeId);
                console.log("COA Sub ID:", coaSubId);

                // Validasi nilai sebelum mengirim permintaan
                if (!coaTypeId || !coaSubId) {
                    console.warn("Tipe atau Sub Akun belum dipilih. Permintaan tidak dikirim.");
                    accountCodeInput.value = ''; // Kosongkan field account_code
                    return;
                }

                const url =
                    `/super-admin/umkm/${umkmId}/coa/generate-account-code?coa_type_id=${coaTypeId}&coa_sub_id=${coaSubId}`;
                console.log("Fetching account code from URL:", url);

                fetch(url)
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Data fetched successfully:", data);
                        if (data && data.account_code) {
                            accountCodeInput.value = data.account_code;
                            console.log("Field 'account_code' updated:", data.account_code);
                        } else {
                            console.warn("Response JSON tidak memiliki properti 'account_code'.");
                            accountCodeInput.value = '';
                        }
                    })
                    .catch(error => {
                        console.error("Error generating account code:", error);
                        accountCodeInput.value = ''; // Kosongkan field jika terjadi error
                    });
            };


            // Event listener untuk perubahan di dropdown
            coaTypeSelect.addEventListener('change', () => {
                console.log("Event 'change' pada dropdown 'coa_type_id' terdeteksi.");
                updateAccountCode();
            });

            coaSubSelect.addEventListener('change', () => {
                console.log("Event 'change' pada dropdown 'coa_sub_id' terdeteksi.");
                updateAccountCode();
            });

            console.log("Script selesai diinisialisasi.");
        });
    </script>
@endsection
