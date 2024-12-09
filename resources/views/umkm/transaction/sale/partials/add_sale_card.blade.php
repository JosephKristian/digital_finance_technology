<!-- Kolom untuk Card Tambah Penjualan -->
<div class="col-md-6 mt-4">
    <div class="card">
        <div class="card-header">
            <button class="btn-link align-middle collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#addSalesAccordion" aria-expanded="false" aria-controls="addSalesAccordion">
                <i class="fas fa-plus text-primary"></i>
            </button>
            <span class="ms-2 align-middle">Tambah Penjualan</span>
        </div>
        <div class="card-body">


            @php
                use Carbon\Carbon;

                // Waktu kedaluwarsa dalam detik (misalnya 300 detik)
                $expirationTime = 300;

                // Cek jika session_start_time ada
                if (session()->has('session_start_time')) {
                    // Ambil waktu mulai sesi
                    $sessionStartTime = session('session_start_time');

                    // Hitung selisih waktu dalam detik
                    $elapsedTime = $sessionStartTime->diffInSeconds(now());

                    // Jika sudah lebih dari waktu kedaluwarsa
                    if ($elapsedTime > $expirationTime) {
                        // Hapus seluruh detail transaksi yang terkait dengan session ini
                        $transactionId = session('transactionId');
                        if ($transactionId) {
                            // Ambil semua detail transaksi yang terkait dengan transactionId
                            $details = \App\Models\TransactionDetail::where('transaction_id', $transactionId)->get();

                            // Update stok produk dan hapus detail transaksi satu per satu
                            foreach ($details as $detail) {
                                // Mengupdate stok produk, menambahkannya sesuai dengan quantity yang ada di detail transaksi
                                \App\Models\Product::where('id', $detail->product_id)->increment(
                                    'stock_quantity',
                                    $detail->quantity,
                                ); // Stock ditambah sesuai quantity

                                // Hapus detail transaksi
                                $detail->delete();
                            }
                        }

                        // Hapus session
                        session()->forget('transactionId');
                        session()->forget('transactionDate');
                        session()->forget('customerName');
                        session()->forget('session_start_time');
                    }
                }
            @endphp


            @if (session('transactionId') || session('customerName') || session('transactionDate'))
                <div class="mb-3">
                    <label for="sales_name" class="form-label">ID Transaksi</label>
                    <input type="text" name="sales_name" id="sales_name" class="form-control"
                        value="{{ session('transactionId') }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control"
                        value="{{ session('customerName') }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="sale_date" class="form-label">Tanggal Penjualan</label>
                    <input type="date" name="sale_date" id="sale_date" class="form-control"
                        value="{{ session('transactionDate') ? Carbon::parse(session('transactionDate'))->format('Y-m-d') : '' }}"
                        disabled>
                </div>
            @else
                <p>Silahkan buat transaksi penjualan dahulu dengan memencet tombol plus di sebelah tambah penjualan.</p>
            @endif





        </div>

        {{-- form tambah penjualan dengan accordion --}}
        <div class="accordion" id="addSales">
            <div class="accordion-item">
                <div id="addSalesAccordion" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#addSales">
                    <div class="accordion-body">
                        {{-- ACCORDION --}}
                        <form action="{{ route('transactions.create') }}" method="POST">
                            @csrf
                            <!-- Input Nama Pelanggan -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-8 mt-4">
                                        <label class="form-label d-flex align-items-center gap-2">
                                            Nama Pelanggan
                                            <!-- Badge untuk tambah pelanggan -->
                                            <span class="badge bg-primary text-white" style="cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                                                <i class="fas fa-plus-circle"></i> Tambah
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Input nama pelanggan dengan Select2 -->
                                <select id="customer_id" name="customer_id" class="form-control" required>
                                    <option value="">Pilih Nama Pelanggan</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sale_date" class="form-label">Tanggal Penjualan</label>
                                <input type="date" name="sale_date" id="sale_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>



                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




@include('umkm.transaction.sale.partials.add_detail_sale')
