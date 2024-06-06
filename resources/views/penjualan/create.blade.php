@extends('layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row gx-4 d-flex justify-content-between">
                <div class="col-auto d-flex align-items-center">
                    <a href="#" class="mr-2">
                        <i class="ri-store-fill fs-4"></i></i>
                    </a>&nbsp;
                    <h5 class="mb-0 mt-0"><strong>Transaksi Penjualan</strong></h5>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <span class="display-6">{{ $formattedmasteruangs }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('store.penjualan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-2">
            <div class="card-body">
                <h4 class="card-title text-center"><strong></strong></h4>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="nota" name="nota" required placeholder="nota">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                            </div>
                            <div class="col-md-6">
                                <select name="type_pembayaran" class="form-control" required>
                                    <option selected disabled value="">Type pembayaran</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="piutang">Piutang</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <select class="form-control select2" id="kode_produk" name="kode_produk" required>
                                    <option selected disabled value="">Pilih Kode Produk</option>
                                    @foreach ($produks as $ices)
                                        <option value="{{ $ices->kode_produk ?? '-' }}" data-nama-produk="{{ $ices->nama_produk ?? '-' }}" data-harga-jual="{{ $ices->harga_jual }}" data-gambar="{{ $ices->gambar_produk ?? '-' }}" data-stok-produk="{{ $ices->stok ?? '-' }}">
                                            {{ $ices->kode_produk ?? '-' }} - {{ $ices->nama_produk ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <textarea class="form-control" name="keterangan" id="keterangan" placeholder="keterangan bisa di isi dengan nama pembeli...."></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" name="total_produk" id="total_produk">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div style="border: 1px solid #ccc; padding: 10px; width: 100%; border-radius: 10px; display: flex; flex-direction: column;">
                            <h1 id="totalHarga" class="mb-3">Rp 0</h1>
                            <input type="hidden" name="grand_total" id="grandhargaInput">
                            <div id="cash_form" style="flex-grow: 1;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                                <input type="number" class="form-control" placeholder="Pembayaran" id="pembayaran" name="pembayaran" aria-label="Pembayaran" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                                <input type="text" class="form-control" name="kembalian" id="kembalianInput" placeholder="Kembalian" readonly>
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
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 ">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="listproduk">
                                <thead>
                                    <tr>
                                        <th class="text-dark"> <span class="badge bg-success">Produk</span></th>
                                        <th class="text-dark text-center"> <span class="badge bg-success">Harga</span></th>
                                        <th class="text-center text-dark"> <span class="badge bg-success">Jumlah Produk</span></th>
                                        <th class="text-center text-dark"> <span class="badge bg-success">Total Harga</span></th>
                                        <th class="text-center text-dark"> <span class="badge bg-success">Aksi</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                <button id="submitBtn" type="submit" class="btn btn-primary">Kirim</button> &nbsp;
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('penjualan.script')
@endsection
