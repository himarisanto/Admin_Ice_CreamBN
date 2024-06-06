<!-- Modal -->
<div class="modal fade" id="add_uang_khusus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><strong>Pengeluaran Khusus</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.pengeluarankhusus') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi :</label>
                        <input id="tanggal_transaksi" type="date" class="form-control" name="tanggal_transaksi">
                    </div>
                      <div class="mb-2">
                        <label for="oleh" class="form-label">Oleh :</label>
                        <input id="oleh" type="text" class="form-control" name="oleh">
                    </div>
                    <div class="mb-2">
                        <label for="nominal" class="form-label">Nominal uang :</label>
                        <div class="input-group input-group-alternative">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="nominal" name="nominal" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="keperluan" class="form-label">keperluan :</label>
                        <textarea id="keperluan" name="keperluan" class="form-control"></textarea>
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
