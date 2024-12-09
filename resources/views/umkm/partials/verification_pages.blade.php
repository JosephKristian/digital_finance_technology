@if (session('umkm_approve') == 0)
    <div class="card mx-auto shadow-lg mt-4" style="max-width: 600px; border-radius: 10px;">
        <div class="card-header text-center bg-info text-white"
            style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h5 class="my-2">Pilih Metode Verifikasi</h5>
        </div>
        <div class="card-body">
            <p class="text-center text-muted">Silakan pilih metode verifikasi yang sesuai untuk menyelesaikan proses
                pengajuan UMKM Anda.</p>
            <div class="d-flex justify-content-center gap-3">
                <!-- Tombol untuk membuka modal Verifikasi UMKM (berkas PDF) -->
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#verifikasiModal">
                    <i class="bi bi-file-earmark-pdf"></i> Verifikasi UMKM (PDF)
                </button>

                <!-- Tombol untuk membuka modal Verifikasi UMKM dengan Token -->
                <button type="button" class="btn btn-warning d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#verifikasiModalToken">
                    <i class="bi bi-key-fill"></i> Gunakan Token Verifikasi
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi -->
    @include('umkm.partials.verification_modal')
@endif


@if (session('umkm_approve') == -1)
    <div class="card mx-auto shadow mt-4" style="max-width: 600px; border-radius: 10px;">
        <div class="card-header text-center bg-success text-white"
            style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <h5 class="my-2">Pengajuan Sedang Diproses</h5>
        </div>
        <div class="card-body text-center">
            <p class="text-muted">Terima kasih! Pengajuan UMKM Anda sedang kami proses. Mohon tunggu hingga proses
                selesai.</p>

            <!-- Tampilkan file PDF -->
            @if (!empty($umkm['pdf_path']))
                <div class="mt-3">
                    <p class="text-info">Dokumen yang diunggah:</p>
                    <a href="{{ asset('storage/' . $umkm['pdf_path']) }}" target="_blank"
                        class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Lihat Dokumen PDF
                    </a>
                    <!-- Gambar tambahan untuk estetika -->
                    {{-- <iframe
                    src="https://docs.google.com/gview?url={{ asset('storage/' . $umkm['pdf_path']) }}&embedded=true"
                    width="600" height="400">
                </iframe>

                {{ asset('storage/' . $umkm['pdf_path']) }} --}}
                </div>
            @else
                <p class="text-danger">Dokumen PDF belum tersedia.</p>
            @endif


        </div>
    </div>

@endif
