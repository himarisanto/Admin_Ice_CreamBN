@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-12 col-md-auto d-flex align-items-center mb-3 mb-md-0">
                    <a href="#" class="mr-2">
                        <i class="ri-clipboard-fill fs-4"></i>
                    </a>
                    <h5 class="mb-0 mt-0"><strong>Rekapan Penjualan Harian</strong></h5>
                </div>
                <div class="col-12 col-md-auto d-flex align-items-center">
                    <form action="{{ route('index.rekapan_harian') }}" method="GET">
                        @csrf
                        <div class="row gx-2">
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <input type="date" class="form-control" name="pilih_tanggal" value="{{ request('pilih_tanggal') }}">
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <input type="text" class="form-control" name="search" placeholder="search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <button type="submit" class="btn btn-success w-100"><i class="ri-search-eye-line"></i></button>
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <input type="hidden" name="reset_filter" id="reset_filter" value="0">
                                <button type="submit" class="btn btn-danger w-100" onclick="resetFilter()" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Filter"><i class="ri-filter-off-line"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title">{{ \Carbon\Carbon::parse(request('pilih_tanggal', now()->format('Y-m-d')))->format('l, d F Y') }}</h5>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('print.harian') }}" class="btn btn-primary" target="_blank"  data-bs-toggle="tooltip" data-bs-placement="right" title="Print Data"><i class="ri-printer-fill"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    @if ($searchMessage)
                        <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                            {{ $searchMessage }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 50px">No</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga Jual</th>
                                <th scope="col">Jumlah Keluar</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($harian as $index => $data)
                                <tr>
                                    <td>{{ $index + $harian->firstItem() }}</td>
                                    <td>{{ $data->kode_produk ?? '-' }} - {{ $data->produks->nama_produk ?? '-' }}</td>
                                    <td>Rp {{ number_format($data->produks->harga_jual, 0, ',', '.' ?? '-') }}</td>
                                    <td>{{ $data->total_jumlah_keluar ?? '-' }}</td>
                                    <td>Rp {{ number_format($data->total_harga_produk, 0, ',', '.' ?? '-') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="col-auto">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination d-flex justify-content-end">
                            {{ $harian->appends(['search' => $searchKeyword, 'pilih_tanggal' => $selectedDate])->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        function resetFilter() {
            document.getElementById('reset_filter').value = '1';
        }
    </script>
@endsection
