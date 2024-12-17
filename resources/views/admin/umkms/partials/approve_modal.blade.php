@foreach ($data as $index => $umkm)
    <!-- Modal Approve -->
    <div class="modal fade" id="approveUmkmModal{{ $umkm['id'] }}" tabindex="-1"
        aria-labelledby="approveUmkmModalLabel{{ $umkm['id'] }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('super-admin.umkm.approve', ['id' => $umkm['id']]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveUmkmModalLabel{{ $umkm['id'] }}">Konfirmasi Approve UMKM
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui UMKM <strong>{{ $umkm['name'] }}</strong>?</p>
                        <p><strong>Perhatian:</strong> Setelah disetujui, perubahan tidak dapat dibatalkan.</p>
                        <!-- Input Password untuk konfirmasi -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-danger font-weight-bold">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span class="text-dark"><strong>Silahkan memasukan password anda untuk
                                        mengkonfirmasi</strong></span>
                            </label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
