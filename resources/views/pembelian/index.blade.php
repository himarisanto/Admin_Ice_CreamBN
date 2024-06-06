@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-auto d-flex align-items-center">
                    <a href="#" class="mr-2">
                        <i class="ri-shopping-cart-2-fill fs-4"></i>
                    </a>&nbsp;
                    <h5 class="mb-0 mt-0"><strong>Transaksi Pembelian</strong></h5>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <span class="display-6">{{ $formattedmasteruangs ?? '' }}</span>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a href="{{ route('create.pembelian') }}" class="btn btn-success"><i class="ri-add-circle-fill"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($pembelians as $index => $item)
            <div class="col-lg-3 mb-0">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="d-flex justify-content-end">
                            <span class="badge rounded-pill bg-dark" onclick="openModal('{{ $item->id }}')" style="cursor: pointer;" title="Detail Transaksi" data-bs-toggle="tooltip" data-bs-placement="top">{{ $pembelians->firstItem() + $index }}</span>
                        </div>
                        <div class="row">
                            <ul class="list-unstyled">
                                <li class="text-muted">
                                    <strong>Nota : {{ $item->nota ?? '-' }}
                                        @if ($item->type_pembayaran == 'cash')
                                            <span class="badge bg-success">Cash</span>
                                        @elseif ($item->type_pembayaran == 'transfer')
                                            <span class="badge bg-info">Transfer</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak di ketahui</span>
                                        @endif
                                    </strong>
                                </li>
                                <li class="text-muted mt-1"><strong>Tanggal : {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d F Y') ?? '-' }}</strong></li>
                                <li class="text-muted mt-1"><strong>Grand Total : Rp {{ number_format($item->grand_total, 0, ',', '.') ?? '-' }}</strong></li>
                                <li class="text-muted"><strong>Total Produk : {{ $item->total_produk ?? '-'}}</strong></li>
                                <li class="text-muted"><strong>Total Bonus : {{ $item->total_bonus ?? '-'}}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-xl-12 mb-0">
                <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                    Belum ada data transaksi Pembelian Produk !
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endforelse
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $pembelians->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $pembelians->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $pembelians->lastPage(); $i++)
                        <li class="page-item">
                            <a class="page-link {{ $pembelians->currentPage() == $i ? 'active' : '' }}" href="{{ $pembelians->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $pembelians->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $pembelians->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    @include('pembelian.modal_detail')
    <script>
        function openModal(id) {
            var modalId = '#detailPembelian-' + id;
            $(modalId).modal('show');
        }
    </script>
@endsection
