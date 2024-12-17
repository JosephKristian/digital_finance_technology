<table class="table table-hover">
    <thead>
        <tr>
            <th>Token</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tokens as $index => $token)
            <tr>
                <td>
                    <div class="input-group">
                        <!-- Input field dengan nilai token, disabled -->
                        <input type="text" class="form-control" value="{{ $token['token'] }}"
                            id="token-{{ $token['id'] }}" readonly>

                        <!-- Tombol untuk menyalin ke clipboard -->
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="copyToClipboard('token-{{ $token['id'] }}')">
                            Copy
                        </button>
                    </div>
                </td>


                <!-- Menampilkan status dengan badge dan keterangan tanggal -->
                <td>
                    @if (\Carbon\Carbon::now()->greaterThan($token['expires_at']))
                        <span class="badge bg-danger">Kedaluwarsa</span>
                        <br>
                        <small>Berlaku hingga:
                            {{ \Carbon\Carbon::parse($token['expires_at'])->format('d M Y, H:i') }}</small>
                    @else
                        <span class="badge bg-success">Aktif</span>
                        <br>
                        <small>Berlaku hingga:
                            {{ \Carbon\Carbon::parse($token['expires_at'])->format('d M Y, H:i') }}</small>
                    @endif
                </td>


                <td>
                    <a href="#" class="btn btn-sm text-danger" data-bs-toggle="modal"
                        data-bs-target="#delete-{{ $token['id'] }}">
                        <i class="fas fa-trash"></i>
                    </a>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
