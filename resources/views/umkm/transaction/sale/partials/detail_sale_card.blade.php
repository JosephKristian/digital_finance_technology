<div class="card-header">
    Detail Penjualan
</div>
<div class="card-body">
    <!-- Tabel Transaksi -->
    <h2>Detail Transaksi</h2>
    @if ($detailTransactions && $detailTransactions->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th> <!-- Kolom aksi -->
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($detailTransactions as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->product->id }}</td>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 2) }}</td>
                        <td>{{ number_format($detail->subtotal, 2) }}</td>
                        <td>
                            <!-- Tombol delete untuk menghapus detail transaksi -->
                            <form action="{{ route('transactions.detail-destroy', $detail->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $total += $detail->subtotal;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td><strong>{{ number_format($total, 2) }}</strong></td>
                    <td></td> <!-- Kosongkan kolom aksi pada baris total -->
                </tr>
            </tfoot>
        </table>

</div>

<div class="card-footer d-flex justify-content-between align-items-center">
    @if ($detailTransactions)
        <!-- Tombol selesai -->
        <form id="completeTransactionForm"
            action="{{ route('transactions.completed', session('transactionId') ?? 'default_value') }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="text" name="total_sales" id="total_sales" class="form-control"
                value="{{ number_format($total, 2) }}" hidden>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control"
                value="{{ session('transactionId') }}" hidden>
            <input type="hidden" name="payment_method_id" id="payment_method_id" value="">

            <!-- Tombol Selesai yang akan membuka modal -->
            <button type="button" id="openPaymentModal" class="btn btn-success btn-sm">
                Selesai
            </button>

        </form>
    @endif
</div>
@include('umkm.transaction.sale.partials.payment_method_modal')
@else
<p class="text-muted">Tidak ada detail transaksi untuk transaksi ID yang tersedia</p>
@endif
