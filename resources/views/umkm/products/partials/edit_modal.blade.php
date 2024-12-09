<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Nama Produk -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                    </div>

                    <!-- Input Harga Beli -->
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Harga Beli</label>
                        <input type="number" name="purchase_price" id="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                    </div>

                    <!-- Input Harga Jual -->
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Jual</label>
                        <input type="number" name="selling_price" id="selling_price" class="form-control" value="{{ $product->selling_price }}" required>
                    </div>

                    <!-- Input Stok -->
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stok</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
                    </div>

                    <!-- Input Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
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
