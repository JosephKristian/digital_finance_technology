<table id="datatablesSimple">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Umkm</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Berkas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach ($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email ?? '-' }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editCustomerModal{{ $customer->id }}">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteCustomerModal{{ $customer->id }}">Hapus</a>
                </td>
            </tr>
            @include('umkm.customers.partials.edit_modal', ['customer' => $customer])
            @include('umkm.customers.partials.delete_modal', ['customer' => $customer])
        @endforeach
    </tbody> --}}
</table>
