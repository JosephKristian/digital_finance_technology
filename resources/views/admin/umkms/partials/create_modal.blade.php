<div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCustomerModalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Nama Pelanggan -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pelanggan</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <!-- Input Nomor Pelanggan -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Pelanggan (Opsional)</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Pelanggan (Opsional)</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>


                    <!-- Input Harga Jual -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Pelanggan</label>
                        <input type="text" name="address" id="address" class="form-control">
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
