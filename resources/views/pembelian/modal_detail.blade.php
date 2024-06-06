@foreach ($pembelians as $key => $item)
    <div class="modal fade" id="detailPembelian-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailPembelian-{{ $item->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mb-5 mt-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <ul class="list-unstyled">
                                        <li>
                                            <h5><i class="ri-checkbox-circle-fill text-primary"></i>
                                                <strong> Nota : {{ $item->nota ?? '-' }}
                                                    @if ($item->type_pembayaran == 'cash')
                                                        <span class="badge bg-success">Cash</span>
                                                    @elseif ($item->type_pembayaran == 'transfer')
                                                        <span class="badge bg-info">Transfer</span>
                                                    @else
                                                        <span class="badge bg-secondary">Tidak di ketahui</span>
                                                    @endif
                                                </strong>
                                            </h5>
                                        </li>
                                        <li>
                                            <h5><i class="ri-checkbox-circle-fill text-primary"></i><strong> Tanggal Transaksi : {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d F Y') ?? '-' }}</strong></h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row my-2 mx-1 justify-content-center">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead style="background-color:#84B0CA ;" class="text-white">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Jumlah Masuk</th>
                                                <th scope="col">Harga Produk</th>
                                                <th scope="col">Total Harga</th>
                                                <th scope="col">Bonus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->detailPembelians as $key => $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->kode_produk ?? '-' }}-{{ $detail->produks->nama_produk ?? '-' }}</td>
                                                    <td>{{ $detail->jumlah_masuk ?? '-' }}</td>
                                                    <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.' ?? '-') }}</td>
                                                    <td>Rp {{ number_format($detail->total_harga, 0, ',', '.' ?? '-') }}</td>
                                                    <td>{{ $detail->bonus ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <textarea name="keterangan" class="form-control" readonly>{{ $item->keterangan ?? '-' }}</textarea>
                                        </div>
                                        <div class="col-xl-5">
                                            <ul class="list-unstyled">
                                                <li class="text-muted ms-3"><strong><span class="text-black me-4">Grand Total</span>: Rp {{ number_format($item->grand_total, 0, ',', '.' ?? '-') }}</strong></li>
                                                <li class="text-muted ms-3 mt-1"><strong><span class="text-black me-3">Pembayaran</span>: Rp {{ number_format($item->pembayaran, 0, ',', '.' ?? '-') }}</strong></li>
                                                <li class="text-muted ms-3 mt-1"><strong><span class="text-black me-4">Kembalian</span> : Rp {{ number_format($item->kembalian, 0, ',', '.' ?? '-') }}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
