<!-- Form Tambah Detail Penjualan -->
<div class="col-md-6 mt-4">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list-alt me-2"></i> Tambah Detail Penjualan
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <input type="text" name="transaction_id" id="transaction_id" class="form-control"
                    value="{{ session('transactionId') }}" hidden>

                <!-- Input Nama Produk -->
                <div class="mb-3">
                    <label for="product_id" class="form-label">Nama Produk</label>
                    <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">Pilih Nama Produk</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}">
                                {{ $product->name }} (Stok: {{ $product->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Jumlah Produk -->
                <div class="mb-3">
                    <label for="product_quantity" class="form-label">Jumlah Produk</label>
                    <input type="number" name="product_quantity" id="product_quantity" class="form-control"
                        min="1" required>
                    <div id="quantity-error" class="text-danger" style="display: none;">Jumlah produk melebihi stok!
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function validateForm() {
        const transactionId = document.getElementById('transaction_id').value;
        console.log('Transaction ID:', transactionId); // Debugging log

        // Cek jika transactionId kosong atau null
        if (!transactionId || transactionId.trim() === '') {
            alert('Transaksi penjualan belum dibuat. Silakan buat transaksi penjualan terlebih dahulu.');
            return false; // Mencegah form di-submit
        }

        return true; // Form valid
    }
</script>
