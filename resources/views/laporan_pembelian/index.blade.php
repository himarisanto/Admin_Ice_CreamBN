@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-12 col-md-auto d-flex align-items-center mb-3 mb-md-0">
                    <a href="#" class="mr-2">
                        <i class="ri-file-text-fill fs-4"></i>
                    </a>
                    <h5 class="mb-0 mt-0"><strong>Laporan Pembelian</strong></h5>
                </div>
                <div class="col-12 col-md-auto d-flex align-items-center">
                    <form action="{{ route('laporan.pembelian') }}" method="GET">
                        @csrf
                        <div class="row gx-2">
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <select class="form-control" name="entri" aria-placeholder="pilih jumlah">
                                    <option selected disabled value="">Pilih jumlah</option>
                                    <option value="10" {{ request('entri') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('entri') == '25' ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('entri') == '50' ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('entri') == '100' ? 'selected' : '' }}>100</option>
                                    <option value="all" {{ request('entri') == 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="baru-lama" {{ request('entri') == 'baru-lama' ? 'selected' : '' }}>Baru -> Lama</option>
                                    <option value="lama-baru" {{ request('entri') == 'lama-baru' ? 'selected' : '' }}>Lama -> Baru</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <input type="date" class="form-control" name="dari" value="{{ request('dari') }}">
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <i class="ri-arrow-left-right-fill"></i>
                            </div>
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <input type="date" class="form-control" name="hingga" value="{{ request('hingga') }}">
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
    <div class="card">
        <div class="card-body mt-2">
            @if (isset($errorMessage))
                <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                    {{ $errorMessage }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nota</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col">Pembelian Produk</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelians as $key => $data)
                            <tr>
                                <td>{{ $data->nota ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_transaksi ?? '-')->format('d F Y') }}</td>
                                <td>
                                    <div style="border: 1px solid #ccc; padding: 10px; width: 100%; border-radius: 10px; display: flex; flex-direction: column;">
                                        @foreach ($data->detailPembelians as $detail)
                                            {{ $detail->jumlah_masuk ?? '-' }} {{ $detail->produks->nama_produk ?? '-' }} = Rp {{ number_format($detail->total_harga, 0, ',', '.' ?? '-') }}<br>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-center"><a href="{{ route('print.pembelian', ['id' => $data->id])}}" target="_blank"  class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Cetak nota"><i class="ri-printer-fill"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $pembelians->links() }}
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
