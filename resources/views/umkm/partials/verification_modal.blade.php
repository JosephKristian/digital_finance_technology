 <!-- Modal Verifikasi -->
 <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi UMKM</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('verification.umkm.pdf') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-3">
                         <label for="name" class="form-label">Nama UMKM</label>
                         <input type="text" class="form-control" id="name" name="name" required>
                     </div>
                     <div class="mb-3">
                         <label for="address" class="form-label">Alamat UMKM</label>
                         <input type="text" class="form-control" id="address" name="address" required>
                     </div>
                     <div class="mb-3">
                         <label for="phone" class="form-label">Telepon UMKM</label>
                         <input type="text" class="form-control" id="phone" name="phone" required>
                     </div>
                     <div class="mb-3">
                         <label for="pdf_path" class="form-label">Upload PDF</label>
                         <input type="file" class="form-control" id="pdf_path" name="pdf_path" accept=".pdf">
                     </div>

                     <button type="submit" class="btn btn-primary">Verifikasi</button>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Verifikasi dengan Token -->
 <div class="modal fade" id="verifikasiModalToken" tabindex="-1" aria-labelledby="verifikasiModalTokenLabel"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="verifikasiModalTokenLabel">Verifikasi UMKM dengan Token</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('verification.umkm.token') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-3">
                         <label for="nameToken" class="form-label">Nama UMKM</label>
                         <input type="text" class="form-control" id="nameToken" name="nameToken" required>
                     </div>
                     <div class="mb-3">
                         <label for="addressToken" class="form-label">Alamat UMKM</label>
                         <input type="text" class="form-control" id="addressToken" name="addressToken" required>
                     </div>
                     <div class="mb-3">
                         <label for="phoneToken" class="form-label">Telepon UMKM</label>
                         <input type="text" class="form-control" id="phoneToken" name="phoneToken" required>
                     </div>
                     <div class="mb-3">
                         <label for="token" class="form-label">Token Admin</label>
                         <input type="text" class="form-control" id="token" name="token" required>
                     </div>

                     <button type="submit" class="btn btn-primary">Verifikasi dengan Token</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
