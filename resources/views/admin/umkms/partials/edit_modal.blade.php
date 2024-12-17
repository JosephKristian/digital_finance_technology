@foreach ($data as $index => $umkm)
    <!-- Modal Edit -->
    <div class="modal fade" id="editUmkmModal{{ $umkm['id'] }}" tabindex="-1" aria-labelledby="editUmkmModalLabel{{ $umkm['id'] }}" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <form action="{{ route('super-admin.umkm.update', ['id' => $umkm['id']]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUmkmModalLabel{{ $umkm['id'] }}">Edit UMKM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input Nama UMKM -->
                        <div class="mb-3">
                            <label for="name{{ $umkm['id'] }}" class="form-label">Nama UMKM</label>
                            <input type="text" name="name" id="name{{ $umkm['id'] }}" class="form-control" value="{{ old('name', $umkm['name']) }}" required>
                        </div>
                        <!-- Input Telepon -->
                        <div class="mb-3">
                            <label for="phone{{ $umkm['id'] }}" class="form-label">Telepon</label>
                            <input type="text" name="phone" id="phone{{ $umkm['id'] }}" class="form-control" value="{{ old('phone', $umkm['phone']) }}" required>
                        </div>
                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email{{ $umkm['id'] }}" class="form-label">Email</label>
                            <input type="email" name="email" id="email{{ $umkm['id'] }}" class="form-control" value="{{ old('email', $umkm['email']) }}" required>
                        </div>
                        <!-- Input Alamat -->
                        <div class="mb-3">
                            <label for="address{{ $umkm['id'] }}" class="form-label">Alamat</label>
                            <textarea name="address" id="address{{ $umkm['id'] }}" class="form-control" rows="3">{{ old('address', $umkm['address']) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
