@foreach ($ices as $data)
    <div class="modal fade" id="Mdl_edit_es-{{ $data->id }}" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('ice.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label for="gambar_produk" class="form-label"><strong>Gambar Produk :
                                        </strong></label>
                                    <input type="file" class="form-control" id="gambar_produk-{{ $data->id }}"
                                        name="gambar_produk">
                                </div>
                                <div class="mt-3">
                                    <img src="{{ $data->gambar_produk ? asset('gambar_produk/' . $data->gambar_produk) : '#' }}"
                                        id="preview-{{ $data->id }}" style="max-width: 100%; height: auto;"
                                        alt="Preview Gambar">
                                </div><br>
                            </div>
                            <div class="col-xl-8">
                                <div class="mb-1">
                                    <label for="kode_produk" class="form-label"><strong>Kode Produk : </strong></label>
                                    <input type="text" class="form-control" id="kode_produk" name="kode_produk"
                                        required value="{{ $data->kode_produk ?? '-' }}">
                                </div>
                                <div class="mb-1">
                                    <label for="nama_produk" class="form-label"><strong>Nama Produk : </strong></label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                        required value="{{ $data->nama_produk ?? '-' }}">
                                </div>
                                <div class="mb-1">
                                    <label for="satuan_id" class="form-label"><strong>Satuan : </strong></label>
                                    <select class="form-select" id="satuan_id" name="satuan_id" required>
                                        <option selected disabled value="">Pilih satuan</option>
                                        @foreach ($satuans as $satuan)
                                            <option value="{{ $satuan->id }}"
                                                {{ $data->satuan_id == $satuan->id ? 'selected' : '' }}>
                                                {{ $satuan->nama_satuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="mb-1">
                                <label for="harga_beli" class="form-label"><strong>Harga Beli : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" required
                                        value="{{ $data->harga_beli ?? '-' }}">
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="harga_jual" class="form-label"><strong>Harga Jual : </strong></label>
                                <div class="input-group input-group-alternative">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" required
                                        value="{{ $data->harga_jual ?? '-' }}">
                                </div>
                            </div> --}}
                                <div class="mb-1">
                                    <label for="harga_beli" class="form-label"><strong>Harga Beli : </strong></label>
                                    <div class="input-group input-group-alternative">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                                            required value="{{ number_format($data->harga_beli, 0, ',', '.') }}"
                                            oninput="formatCurrency2(this)">
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label for="harga_jual" class="form-label"><strong>Harga Jual : </strong></label>
                                    <div class="input-group input-group-alternative">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                                            required value="{{ number_format($data->harga_jual, 0, ',', '.') }}"
                                            oninput="formatCurrency2(this)">
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label for="keterangan" class="form-label"><strong>Keterangan : </strong></label>
                                    <textarea class="form-control" name="keterangan" id="keterangan">{{ $data->keterangan ?? '-' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>z
        </div>
    </div>

    <script>
        function lihatImage() {
            // Ambil elemen input file
            var input = document.getElementById('gambar_produk-{{ $data->id }}');

            // Ambil elemen untuk menampilkan preview
            var preview = document.getElementById('preview-{{ $data->id }}');

            // Setelah pemilihan berkas, tampilkan gambar yang dipilih
            if (input.files && input.files[0]) {
                // Validasi tipe file
                var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(input.files[0].type)) {
                    alert('Silakan pilih file gambar (JPEG, PNG, atau GIF).');
                    input.value = ''; // Reset input file
                    return;
                }

                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Tampilkan gambar
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('gambar_produk-{{ $data->id }}').addEventListener('change', lihatImage);

        function formatCurrency2(input) {
            let value = input.value;

            // Remove all non-numeric characters except for comma and dot
            value = value.replace(/[^\d,]/g, '');

            // Replace comma with dot if used as decimal separator
            if (value.includes(',')) {
                value = value.replace(',', '.');
            }

            let parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Rejoin the parts with a comma if there's a decimal part
            input.value = parts.length > 1 ? parts.join(',') : parts[0];
        }


        // Format initial values
        document.addEventListener('DOMContentLoaded', (event) => {
            let hargaBeliElements = document.querySelectorAll('input[name="harga_beli"]');
            let hargaJualElements = document.querySelectorAll('input[name="harga_jual"]');

            hargaBeliElements.forEach((element) => {
                if (element && element.value) {
                    element.value = formatInitialCurrency(element.value);
                }
            });

            hargaJualElements.forEach((element) => {
                if (element && element.value) {
                    element.value = formatInitialCurrency(element.value);
                }
            });
        });
    </script>
@endforeach
