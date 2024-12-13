<table class="table table-bordered">
    <thead>
        <tr>
            <td class="text-center"><strong>No</strong></td>
            <td class="text-center"><strong>ID Produk</strong></td>
            <td class="text-center"><strong>Nama Produk</strong></td>
            <td class="text-center"><strong>Total Produk yang Terjual</strong></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $index => $transaction)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $transaction->product_id }}</td>
                <td class="text-center">{{ $transaction->product_name }}</td>
                <td class="text-center">{{ $transaction->quantity }} pcs</td>
            </tr>
        @endforeach
    </tbody>
</table>
