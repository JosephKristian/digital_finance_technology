<table class="table table-bordered table-striped">
    <thead>
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
                    {{ $entry->type == 'debit' ? number_format($entry->amount, 2) : '-' }}
                </td>
                <td class="text-end">
                    {{ $entry->type == 'credit' ? number_format($entry->amount, 2) : '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
