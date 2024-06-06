@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-12 col-md-auto d-flex align-items-center mb-3 mb-md-0">
                    <a href="#" class="mr-2">
                        <i class="ri-clipboard-fill fs-4"></i>
                    </a>
                    <h5 class="mb-0 mt-0"><strong>Pengeluaran Khusus</strong></h5>
                </div>
                <div class="col-12 col-md-auto d-flex align-items-center">
                    <form action="{{ route('index.pengeluarankhusus') }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div class="row gx-2">
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        @php
                            $selectedMonth = request('bulan') ? date('F Y', strtotime(request('bulan'))) : date('F Y');
                        @endphp
                        <h5 class="card-title">Bulan {{ $selectedMonth }}</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_uang_khusus"><i class="ri-add-circle-fill"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    @if (isset($warning))
                        <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                            {{ $warning }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 50px">No</th>
                                <th scope="col">Tanggal Transaksi</th>
                                <th scope="col">Oleh</th>
                                <th scope="col">Nominal Uang</th>
                                <th scope="col">Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keluarkhusus as $data)
                                <tr>
                                    <th scope="row">{{ ++$counter ?? '-' }}</th>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_transaksi ?? '')->format('d F Y') }}</td>
                                    <td>{{ $data->oleh ?? '-' }}</td>
                                    <td>Rp {{ number_format($data->nominal, 0, ',', '.' ?? '-') }}</td>
                                    <td>{{ $data->keperluan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pengeluaran khusus</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-auto">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination d-flex justify-content-end">
                            {{ $keluarkhusus->links() }}
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

    @include('pengeluaran_khusus.modal_add')
@endsection
