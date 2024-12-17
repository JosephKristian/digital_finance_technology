<table class="table table-hover table-bordered align-middle">
    <thead class="table-dark text-center">
        <tr>
            <th style="width: 40%;">Token</th>
            <th style="width: 30%;">Status</th>
            <th style="width: 10%;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tokens as $index => $token)
            <tr>
                <!-- Kolom Token -->
                <td>
                    <div class="input-group">
                        <!-- Input field readonly -->
                        <input type="text" class="form-control form-control-sm" value="{{ $token['token'] }}"
                               id="token-{{ $token['id'] }}" readonly>

                        <!-- Tombol Copy -->
                        <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="copyToClipboard('token-{{ $token['id'] }}')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                </td>

                <!-- Kolom Status -->
                <td class="text-center">
                    @if (\Carbon\Carbon::now()->greaterThan($token['expires_at']))
                        <span class="badge bg-danger">Kedaluwarsa</span>
                    @else
                        <span class="badge bg-success">Aktif</span>
                    @endif
                    <br>
                    <small class="text-muted">
                        Berlaku hingga: {{ \Carbon\Carbon::parse($token['expires_at'])->format('d M Y, H:i') }}
                    </small>
                </td>

                <!-- Kolom Aksi -->
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                       data-bs-target="#delete-{{ $token['id'] }}" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
