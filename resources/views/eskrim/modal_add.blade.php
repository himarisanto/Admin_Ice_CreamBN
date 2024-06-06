<div class="modal fade" id="Mdl_tambah_es" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('ice.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="gambar_produk" class="form-label"><strong>Gambar Produk : </strong></label>
                                <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" onchange="lihaImage()">
                            </div>
                            <div class="mt-3">
                                <img src="#" id="preview1" style="max-width: 100%; height: auto; display: none;" alt="Preview Gambar">
                            </div><br>
                        </div>
                        <div class="col-xl-8">
                            <div class="mb-1">
                                <label for="kode_produk" class="form-label"><strong>Kode Produk : </strong></label>
                                <input type="text" class="form-control" id="kode_produk" name="kode_produk" required>
                            </div>
                            <div class="mb-1">
                                <label for="nama_produk" class="form-label"><strong>Nama Produk : </strong></label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                            </div>
                            <div class="mb-1">
                                <label for="satuan_id" class="form-label"><strong>Satuan : </strong></label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select flex-grow-1" id="satuan_id" name="satuan_id">
                                        <option selected disabled value="">Pilih Satuan</option>
                                        @foreach ($satuans as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_satuan ?? '-' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-2" id="PlusSatuan"><i class="ri-add-circle-fill text-success"></i></span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="harga_beli" class="form-label"><strong>Harga Beli : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="harga_jual" class="form-label"><strong>Harga Jual : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="keterangan" class="form-label"><strong>Keterangan : </strong></label>
                                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function lihaImage() {
        // Ambil elemen input file
        var input = document.getElementById('gambar_produk');

        // Ambil elemen untuk menampilkan preview
        var preview = document.getElementById('preview1');

        // Setelah pemilihan berkas, tampilkan gambar yang dipilih
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Tampilkan gambar
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@include('eskrim.add_satuan')
