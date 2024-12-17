<div class="modal fade" id="createTokenModal" tabindex="-1" aria-labelledby="createTokenModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <form action="{{ route('token.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTokenModalLabel">Buat Token Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Masa Berlaku -->
                    <div class="mb-3">
                        <label for="expires_at" class="form-label">Masa Berlaku Token</label>
                        <input 
                            type="datetime-local" 
                            name="expires_at" 
                            id="expires_at" 
                            class="form-control" 
                            required 
                            placeholder="Pilih tanggal dan waktu">
                        <small class="form-text text-muted">
                            Pilih tanggal dan waktu kedaluwarsa token.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


@foreach ($tokens as $token)
    <div class="modal fade" id="delete-{{ $token['id'] }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $token['id'] }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $token['id'] }}">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus token ini? Tindakan ini tidak dapat dibatalkan.
                    <p><strong>Token:</strong> {{ $token['token'] }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('token.destroy', $token['id']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

