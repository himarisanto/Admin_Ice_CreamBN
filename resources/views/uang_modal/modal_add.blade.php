<!-- Modal -->
<div class="modal fade" id="add_uang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><strong>Uang Modal</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-uang-modal" action="{{ route('store.uangmodal') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="tanggal_simpan" class="form-label">Tanggal simpan :</label>
                        <input id="tanggal_simpan" type="date" class="form-control" name="tanggal_simpan">
                    </div>
                    <div class="mb-1">
                        <label for="nominal_uang" class="form-label">Nominal uang :</label>
                        <div class="input-group input-group-alternative">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" id="nominal_uang" name="nominal_uang" required>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label for="keterangan" class="form-label">Keterangan :</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
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
    function formatRupiah(value) {
        const numberString = value.replace(/[^0-9]/g, '').toString();
        const split = numberString.split('');
        const sisa = split.length % 3;
        let rupiah = split.slice(0, sisa).join('');
        const ribuan = split.slice(sisa).join('').match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

    $(document).ready(function() {
        $('#nominal_uang').on('input', function() {
            let value = $(this).val();
            $(this).val(formatRupiah(value)); // Format nilai dalam input
        });

        // Submit form modal
        $('#form-uang-modal').on('submit', function(event) {
            event.preventDefault();
            let nominal_uang = $('#nominal_uang').val().replace(/\./g, ''); // Hilangkan titik
            $('#nominal_uang').val(nominal_uang); // Set nilai kembali ke input

            // Submit form menggunakan AJAX atau form submit biasa
            $(this).unbind('submit').submit(); // Submit form setelah penghapusan titik
        });
    });
</script>
