<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Nama Produk -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- Input Harga Beli -->
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Harga Beli</label>
                        <input type="number" name="purchase_price" id="purchase_price" class="form-control" required>
                    </div>

                    <!-- Input Harga Jual -->
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Jual</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" required>
                    </div>

                    <!-- Input Stok -->
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stok</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" required>
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

