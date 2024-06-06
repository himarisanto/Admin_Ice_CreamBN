@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-auto d-flex align-items-center">
                    <a href="#" class="mr-2">
                        <i class="ri-store-fill fs-4"></i>
                    </a>&nbsp;
                    <h5 class="mb-0 mt-0"><strong>Transaksi Penjualan</strong></h5>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <span class="display-6">{{ $formattedmasteruangs ?? '' }}</span>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a href="{{ route('create.penjualan') }}" class="btn btn-success"><i class="ri-add-circle-fill"></i></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($penjualans as $index => $item)
            <div class="col-md-3 mb-0">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="d-flex justify-content-end">
                            <span class="badge rounded-pill bg-dark" onclick="openModal('{{ $item->id }}')" style="cursor: pointer;" title="Detail Transaksi" data-bs-toggle="tooltip" data-bs-placement="top">
                                {{ $penjualans->firstItem() + $index }}
                            </span>
                        </div>
                        <div class="row">
                            <ul class="list-unstyled">
                                <li class="text-muted"> <strong>Nota : {{ $item->nota ?? '-' }}
                                        @if ($item->type_pembayaran == 'cash')
                                            <span class="badge bg-success">Cash</span>
                                        @elseif ($item->type_pembayaran == 'transfer')
                                            <span class="badge bg-info">Transfer</span>
                                        @elseif ($item->type_pembayaran == 'piutang' && $totalbayarhutang->has($item->id) && $item->grand_total > $totalbayarhutang[$item->id])
                                            <span class="badge bg-danger">Piutang</span>
                                        @elseif($item->type_pembayaran == 'piutang' && $totalbayarhutang->has($item->id) && $item->grand_total == $totalbayarhutang[$item->id])
                                            <span class="badge bg-dark">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Piutang</span>
                                        @endif
                                    </strong></li>
                                <li class="text-muted mt-1"><strong>Tanggal : {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d F Y') ?? '-' }}</strong></li>
                                <li class="text-muted mt-1"><strong>Grand Total : Rp {{ number_format($item->grand_total, 0, ',', '.' ?? '-') }}</strong></li>
                                <li class="text-muted"><strong>Total Produk : {{ $item->total_produk ?? '-' }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-xl-12 mb-0">
                <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                    Belum ada data transaksi Penjualan Produk !
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endforelse
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $penjualans->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $penjualans->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $penjualans->lastPage(); $i++)
                        <li class="page-item">
                            <a class="page-link {{ $penjualans->currentPage() == $i ? 'active' : '' }}" href="{{ $penjualans->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $penjualans->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $penjualans->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    @include('penjualan.modal_detail')
    <script>
        function openModal(id) {
            var modalId = '#detailPenjualan-' + id;
            $(modalId).modal('show');
        }
    </script>
@endsection
