<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Account Code</th>
            <th>Account Name</th>
            <th>Category</th>
            <th>Parent</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($coas as $coa)
            <tr>
                <td>{{ $coa->account_code }}</td>
                <td>{{ $coa->account_name }}</td>
                <td>{{ ucfirst($coa->category) }}</td>
                <td>{{ $coa->parent ? $coa->parent->account_name : '-' }}</td>
                <td class="text-center">
                    <a href="{{ route('super-admin.coa.edit', [$umkm->id, $coa->id]) }}" class="btn btn-sm btn-primary" title="Edit COA">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('super-admin.coa.destroy', [$umkm->id, $coa->id]) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus COA" onclick="return confirm('Hapus COA ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data COA.</td>
            </tr>
        @endforelse
    </tbody>
</table>
