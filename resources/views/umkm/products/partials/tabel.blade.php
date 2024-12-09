<table id="datatablesSimple">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </tfoot>
    <tbody>
        @forelse ($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editProductModal{{ $product->id }}">
                        Edit
                    </a>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteProductModal{{ $product->id }}">
                        Hapus
                    </a>
                </td>
            </tr>

            <!-- Include Edit Modal -->
            @include('umkm.products.partials.edit_modal', ['product' => $product])

            <!-- Include Delete Modal -->
            @include('umkm.products.partials.delete_modal', ['product' => $product])
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data produk.</td>
            </tr>
        @endforelse
    </tbody>
</table>