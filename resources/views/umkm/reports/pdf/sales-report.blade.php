<table border="1" width="100%" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th colspan="4">
                <div style="text-align: center">
                    <h5 style="margin: 0">Telkom University</h5>
                    <h5 style="margin: 0">LAPORAN PENJUALAN PRODUK</h5>
                    <h5 style="margin: 0">
                        Periode {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </h5>
                </div>
            </th>
        </tr>
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
