 <!-- Modal Tambah Data Satuan -->
 <div class="modal fade" id="Mdl_satuan" data-bs-backdrop="static" tabindex="-1">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="Mdl_satuanLabel">Tambah Satuan Produk</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ route('store.satuan') }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <div class="modal-body">
                     <div class="table-responsive">
                         <table id="modalsatuan" class="table table-striped table-bordered">
                             <thead>
                                 <tr>
                                     <th scope="col">Satuan</th>
                                     <th scope="col">Keterangan</th>
                                     <th style="width: 10px"><button type="button" class="btn btn-success tambahBaris"><i class="ri-add-circle-line"></i></button></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td><input type="text" class="form-control" name="nama_satuan[]" required></td>
                                     <td>
                                         <textarea class="form-control" name="keterangan[]"></textarea>
                                     </td>
                                     <td class="text-center"><button type="button" class="btn btn-danger delete-row"><i class="ri-delete-bin-line"></i></button></td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Kirim</button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

<script>
     $(document).ready(function() {
         // Tambah Baris di Modal Satuan
         $('#modalsatuan').on('click', '.tambahBaris', function() {
             console.log('Menambah Baris');
             // Dapatkan jumlah baris saat ini
             var rowCount = $('#modalsatuan tbody tr').length;

             // Buat baris baru dengan input kosong
             var newRow = '<tr>' +
                 '<td><input type="text" class="form-control" name="nama_satuan[]" required></td>' +
                 '<td> <textarea class="form-control" name="keterangan[]"></textarea></td>' +
                 '<td class="text-center"><button class="btn btn-danger delete-row"><i class="ri-delete-bin-line"></i></button></td>' +
                 '</tr>';

             // Tambahkan baris baru ke dalam tabel
             $('#modalsatuan tbody').append(newRow);
         });
         $('#modalsatuan').on('submit', function() {
             console.log('Data yang akan dikirim:', $(this).serialize());
         });
         // Menangani klik pada tombol "Hapus Baris"
         $('#modalsatuan tbody').on('click', '.delete-row', function() {
             // Hapus baris saat tombol "Hapus Baris" diklik
             $(this).closest('tr').remove();
         });
     });
 </script>
