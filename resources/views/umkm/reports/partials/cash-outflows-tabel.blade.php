<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <td class="text-center"><strong>Tanggal</strong></td>
            <td class="text-center"><strong>Keterangan</strong></td>
            <td class="text-center"><strong>Nominal</strong></td>
        </tr>
        @foreach ($cashOutflows as $outflow)
            <tr>
                <td class="text-center">{{ $outflow['date'] }}</td>
                @foreach ($outflow['opposites'] as $opposite)
                    <td>{{ $opposite['account_name'] }}</td>
                @endforeach
                <td class="text-end">{{ number_format($outflow['total_amount'], 2) }}</td>
            </tr>
        @endforeach

        <tr>
            <td class="text-center" colspan="2"><strong>Total</strong></td>
            <td class="text-end"><strong>{{ number_format($totalCashOutflow, 2) }}</strong></td>

        </tr>
    </tbody>
</table>
