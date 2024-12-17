@foreach ($data as $index => $umkm)
    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteUmkmModal{{ $umkm['id'] }}" tabindex="-1"
        aria-labelledby="deleteUmkmModalLabel{{ $umkm['id'] }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('super-admin.umkm.destroy', ['id' => $umkm['id']]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUmkmModalLabel{{ $umkm['id'] }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus UMKM <strong>{{ $umkm['name'] }}</strong>?</p>

                        <!-- Input Password untuk konfirmasi -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-danger font-weight-bold">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span class="fw-bold">Perhatian:</span>
                                Anda akan menghapus data <span class="text-primary">{{ $umkm['name'] }}</span>.
                                Data ini tidak dapat dipulihkan setelah dihapus.
                                <br>
                                Apakah Anda yakin ingin melanjutkan aksi ini? 
                                <br>
                                <span class="text-dark"><strong>Silahkan memasukan password anda untuk mengkonfirmasi</strong></span>
                            </label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
