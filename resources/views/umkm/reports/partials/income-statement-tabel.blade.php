<table class="table table-bordered table-striped">
                   
    <tbody>
        <tr>
            <td><strong>Pendapatan</strong></td>
            <td colspan="3"></td>
        </tr>
        @foreach ($incomeDetails as $income)
            <tr>
                <td></td>
                <td class="ps-4">{{ $income->coa->account_name }}</td>
                <td>Rp {{ number_format($income->total_amount, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td class="ps-4">Biaya Produksi</td>
            <td>Rp - {{ number_format($productionCosts, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Laba Kotor</strong></td>
            <td></td>
            <td></td>
            <td>Rp {{ number_format($grossProfit, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Beban</strong></td>
            <td colspan="3"></td>
        </tr>
        @foreach ($expensesDetails as $expense)
            <tr>
                <td></td>
                <td class="ps-4">{{ $expense->coa->account_name }}</td>
                <td>Rp {{ number_format($expense->total_amount, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td><strong>Total Beban</strong></td>
            <td></td>
            <td></td>
            <td>Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Laba Bersih Operasional</strong></td>
            <td></td>
            <td></td>
            <td>Rp {{ number_format($operationalNetProfit, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Pendapatan Non Operasional</strong></td>
            <td colspan="3"></td>
        </tr>
        @foreach ($nonOperationalIncome as $nopIncome)
        <tr>
            <td></td>
            <td class="ps-4">{{ $nopIncome->coa->account }}</td>
            <td>Rp {{ number_format($nopIncome->total_amount, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td><strong>Total Pendapatan Non Operasional</strong></td>
            <td></td>
            <td></td>
            <td>Rp {{ number_format($totalNonOperationalIncome, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Laba Bersih</strong></td>
            <td></td>
            <td></td>
            <td><strong>Rp {{ number_format($netProfit, 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>