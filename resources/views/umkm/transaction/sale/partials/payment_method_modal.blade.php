<!-- Modal Pilihan Metode Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Pilihan Metode Pembayaran -->
          @foreach ($paymentMethods as $method)
              <div class="payment-method" style="margin-bottom: 10px; cursor: pointer; border: 1px solid #ddd; padding: 10px; border-radius: 5px;" data-method-id="{{ $method->id }}">
                  <strong>{{ $method->name }}</strong>
                  <p>{{ $method->description ?? 'Deskripsi metode pembayaran' }}</p>
              </div>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="confirmPaymentBtn" class="btn btn-primary">Konfirmasi Pembayaran</button>
        </div>
      </div>
    </div>
  </div>