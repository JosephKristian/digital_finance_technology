<table class="table table-bordered">
    <tbody>
        <tr>
            <td class="text-center"><strong>Tanggal</strong></td>
            <td class="text-center"><strong>Keterangan</strong></td>
            <td class="text-center"><strong>Nominal</strong></td>
        </tr>
        @foreach ($cashOutflows as $inflow)
            <tr>
                <td class="text-center">{{ $inflow['date'] }}</td>
                <td>{{ $inflow['account_name'] }}</td>
                <td class="text-end">{{ number_format($inflow['total_amount'], 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center" colspan="2"><strong>Total</strong></td>
            <td class="text-end"><strong>{{ number_format($totalCashOutflow, 2) }}</strong></td>

        </tr>
    </tbody>
</table>
