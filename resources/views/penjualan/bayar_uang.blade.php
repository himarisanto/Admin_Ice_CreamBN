<!-- Modal -->
<div class="modal fade" id="modalBayarUang-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Sisa Hutang = Rp
                    @php
                        $totalPembayaran = $item->bayarHutangs->sum('bayar');
                        $sisaHutang = $item->grand_total - $totalPembayaran;
                    @endphp
                    {{ number_format($sisaHutang, 0, ',', '.') }}
                </h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('store.hutang') }}" method="POST" enctype="multipart/form-data" id="formBayar">
                    @csrf
                    <div class="mb-1">
                        <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi :</label>
                        <input id="tanggal_transaksi" type="date" class="form-control" name="tanggal_transaksi" required>
                        <input type="hidden" name="penjualan_id" value="{{ $item->id }}">
                    </div>
                    <div class="mb-1">
                        <label for="bayar" class="form-label">Bayar :</label>
                        <input id="bayar" type="text" class="form-control" name="bayar" required>
                    </div>
                    <div class="mb-1">
                        <label for="oleh" class="form-label">Oleh :</label>
                        <input id="oleh" type="text" class="form-control" name="oleh" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan :</label>
                        <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>
                    <div class="text-center">
                        <button id="kirimutang" type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
