<table id="datatablesSimple" class="table table-striped table-hover">
    <thead class="table-dark">
        <tr class="text-center">
            <th>No</th>
            <th>Nama UMKM</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Berkas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $umkm)
            <tr>
                <!-- No -->
                <td class="text-center">{{ $index + 1 }}</td>

                <!-- Nama UMKM -->
                <td>{{ $umkm['name'] }}</td>

                <!-- Telepon -->
                <td>{{ $umkm['phone'] }}</td>

                <!-- Email -->
                <td>{{ $umkm['email'] ?? '-' }}</td>

                <!-- Alamat -->
                <td>{{ $umkm['address'] }}</td>

                <!-- Berkas -->
                <td class="text-center">
                    @if ($umkm['pdf'] != null || $umkm['pdf'] != '')
                        <a href="{{ route('super-admin.umkm.showPDF', ['filename' => urlencode($umkm['pdf'])]) }}"
                            target="_blank" class="btn btn-link btn-sm text-decoration-none">
                            Lihat Berkas
                        </a>
                    @else
                        <span class="text-muted">
                            {{ $umkm['approve'] == 1 ? 'Sudah diverifikasi' : 'Belum upload berkas' }}
                        </span>
                    @endif
                </td>

                <!-- Status -->
                <td class="text-center">
                    @if ($umkm['approve'] == 1)
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($umkm['approve'] == 0)
                        <span class="badge bg-danger">Belum Lengkap</span>
                    @elseif ($umkm['approve'] == -1)
                        <span class="badge bg-warning">Belum Disetujui</span>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#approveUmkmModal{{ $umkm['id'] }}">
                            <i class="bi bi-check-circle"></i> Approve
                        </a>
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </td>

                <!-- Aksi -->
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu{{ $umkm['id'] }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $umkm['id'] }}">
                            <!-- Detail Chart of Account -->
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('super-admin.coa.index', ['umkm_id' => $umkm['id']]) }}">
                                    <i class="fas fa-file-alt text-info"></i> Lihat COA
                                </a>
                            </li>

                            <!-- Edit -->
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editUmkmModal{{ $umkm['id'] }}">
                                    <i class="fas fa-edit text-primary"></i> Edit
                                </a>
                            </li>

                            <!-- Hapus -->
                            <li>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                    data-bs-target="#deleteUmkmModal{{ $umkm['id'] }}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </li>


                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
