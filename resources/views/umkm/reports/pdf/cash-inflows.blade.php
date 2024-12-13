<table border="1" width="100%" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th colspan="3">
                <div style="text-align: center">
                    <h5 style="margin: 0">Telkom University</h5>
                    <h5 style="margin: 0">LAPORAN PENERIMAAN KAS</h5>
                    <h5 style="margin: 0">
                        Periode {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </h5>
                </div>
            </th>
        </tr>
        <tr>
            <td class="text-center"><strong>Tanggal</strong></td>
            <td class="text-center"><strong>Keterangan</strong></td>
            <td class="text-center"><strong>Nominal</strong></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($cashInflows as $inflow)
            <tr>
                <td class="text-center">{{ $inflow['date'] }}</td>
                <td>{{ $inflow['account_name'] }}</td>
                <td class="text-end">{{ number_format($inflow['total_amount'], 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center" colspan="2"><strong>Total</strong></td>
            <td class="text-end"><strong>{{ number_format($totalCashInflow, 2) }}</strong></td>
        </tr>
    </tbody>
</table>
