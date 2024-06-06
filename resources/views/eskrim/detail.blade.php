@foreach($ices as $data)
<div class="modal fade" id="Mdl_detail_es-{{$data->id}}" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="gambar_produk" class="form-label"><strong>Gambar Produk : </strong></label>
                                <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" required disabled>
                            </div>
                            <div class="mt-3">
                                <img src="{{ $data->gambar_produk ? asset('gambar_produk/' . $data->gambar_produk) : '#' }}" id="preview{{ $data->id }}" style="max-width: 100%; height: auto;" alt="Preview Gambar">
                            </div><br>
                        </div>
                        <div class="col-xl-8">
                            <div class="mb-1">
                                <label for="kode_produk" class="form-label"><strong>Kode Produk : </strong></label>
                                <input type="text" class="form-control" id="kode_produk" name="kode_produk" required value="{{$data->kode_produk ?? '-'}}" readonly>
                            </div>
                            <div class="mb-1">
                                <label for="nama_produk" class="form-label"><strong>Nama Produk : </strong></label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required value="{{$data->nama_produk ?? '-'}}" readonly>
                            </div>
                            <div class="mb-1">
                                <label for="satuan_id" class="form-label"><strong>Satuan : </strong></label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select" id="satuan{{ $data->id }}" name="satuan" required disabled>
                                        <option selected disabled value="">Pilih Satuan</option>
                                        @foreach ($satuans as $satuanLoop)
                                        <option value="{{ $satuanLoop->id }}" {{ $data->satuan_id == $satuanLoop->id ? 'selected' : '' }}>
                                            {{ $satuanLoop->nama_satuan }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <span class="ms-2" id="PlusSatuan"><i class="fas fa-plus-circle text-primary"></i></span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="harga_beli" class="form-label"><strong>Harga Beli : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" required value="{{$data->harga_beli ?? '-'}}" readonly>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="harga_jual" class="form-label"><strong>Harga Jual : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" required value="{{$data->harga_jual ?? '-'}}" readonly>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="keterangan" class="form-label"><strong>Keterangan : </strong></label>
                                <textarea class="form-control" name="keterangan" id="keterangan" readonly>{{$data->keterangan ?? '-'}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
