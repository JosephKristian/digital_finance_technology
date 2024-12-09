<div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Nama Pelanggan -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pelanggan</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                    </div>
                    <!-- Input Nomor Pelanggan -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon (Opsional)</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Pelanggan (Opsional)</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}">
                    </div>
                    <!-- Input Alamat Pelanggan -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Pelanggan</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $customer->address) }}" >
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
