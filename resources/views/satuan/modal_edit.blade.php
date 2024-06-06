 <!-- Modal Edit Data Satuan -->
 @foreach($satuans as $data)
 <div class="modal fade" id="Mdl_edit_satuan-{{$data->id}}" data-bs-backdrop="static" tabindex="-1">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="Mdl_edit_satuan-{{$data->id}}Label">Edit Satuan Produk</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ route('update.satuan', $data->id) }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 @method('PUT')
                 <div class="modal-body">
                     <div class="table-responsive">
                         <table id="modalsatuan" class="table table-striped table-bordered">
                             <thead>
                                 <tr>
                                     <th scope="col">Satuan</th>
                                     <th scope="col">Keterangan</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td><input type="text" class="form-control" name="nama_satuan" required value="{{$data->nama_satuan ?? '-'}}"></td>
                                     <td>
                                         <textarea class="form-control" name="keterangan">{{$data->keterangan ?? '-'}}</textarea>
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Update</button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 @endforeach