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
     <tbody>
         @foreach ($data as $index => $umkm)
             <tr>
                 <td class="text-center">{{ $index + 1 }}</td>
                 <td>{{ $umkm['name'] }}</td> <!-- Pemanggilan menggunakan array -->
                 <td>{{ $umkm['phone'] }}</td> <!-- Pemanggilan menggunakan array -->
                 <td>{{ $umkm['email'] ?? '-' }}</td> <!-- Pemanggilan nested array -->
                 <td>{{ $umkm['address'] }}</td> <!-- Pemanggilan menggunakan array -->
                 <td>
                     @if ($umkm['pdf'] != null || $umkm['pdf'] != '')
                         <a href="{{ route('super-admin.umkm.showPDF', ['filename' => urlencode($umkm['pdf'])]) }}"
                             target="_blank">Lihat Berkas</a>
                     @else
                         @if ($umkm['approve'] == 1)
                             <span>Umkm sudah verifikasi menggunakan token</span>
                         @else
                             <span>Umkm belum mengupload berkas</span>
                         @endif
                     @endif
                 </td>
                 <td>
                     @if ($umkm['approve'] == 1)
                         <span class="badge bg-success">Disetujui</span>
                     @elseif ($umkm['approve'] == 0)
                         <span class="badge bg-danger">Belum lengkap</span>
                     @elseif ($umkm['approve'] == -1)
                         <span class="badge bg-warning">Belum Disetujui</span>
                         <!-- Tombol Approve (akan memunculkan modal untuk approval) -->
                         <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                             data-bs-target="#approveUmkmModal{{ $umkm['id'] }}">
                             <i class="bi bi-check-circle"></i> Approve
                         </a>
                     @else
                         <span class="badge bg-secondary">Tidak Diketahui</span>
                     @endif
                 </td>


                 <td>
                     <!-- Tombol Edit -->
                     <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                         data-bs-target="#editUmkmModal{{ $umkm['id'] }}">Edit</a>

                     <!-- Tombol Hapus -->
                     <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                         data-bs-target="#deleteUmkmModal{{ $umkm['id'] }}">Hapus</a>
                 </td>
             </tr>
         @endforeach
     </tbody>
 </table>
