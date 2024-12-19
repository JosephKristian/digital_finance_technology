<table border="1" width="100%" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th colspan="6">
                <div style="text-align: center">
                    <h5 style="margin: 0">Telkom University</h5>
                    <h5 style="margin: 0">BUKU BESAR</h5>
                    <h5 style="margin: 0">
                        Periode {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </h5>
                </div>
            </th>
        </tr>
        <tr>
            <th class="text-center"><strong>ID</strong></th>
            <th class="text-center"><strong>Tanggal</strong></th>
            <th class="text-center"><strong>Keterangan</strong></th>
            <th class="text-center"><strong>Ref</strong></th>
            <th class="text-center"><strong>Debit</strong></th>
            <th class="text-center"><strong>Kredit</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($generalLedger as $entry)
            <tr>
                <td class="text-center">{{ $entry->transaction_id }}</td>
                <td class="text-center">{{ $entry->transaction_date }}</td>
                <td>
                    <div style="padding-left: {{ $entry->type == 'credit' ? '20px' : '0px' }};">
                        {{ $entry->account_name }}
                    </div>
                </td>
                <td class="text-center">{{ $entry->account_code }}</td>
                <td class="text-end">
                    {{ $entry->type == 'debit' ? 'Rp ' . number_format($entry->amount, 0, ',', '.') : '-' }}
                </td>
                <td class="text-end">
                    {{ $entry->type == 'credit' ? 'Rp ' . number_format($entry->amount, 0, ',', '.') : '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
