 @extends('layout.master')
 @section('content')
     <div class="row">
         <div class="col-lg-12">
             <div class="row">
                 <div class="col-xxl-8 col-lg-6">
                     <div class="card info-card revenue-card">
                         <div class="card-body">
                             <h5 class="card-title">Uang Kas <span></span></h5>

                             <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary">
                                     <a href="{{ route('index.uangmodal') }}" class="ri-exchange-dollar-fill text-white"></a>
                                 </div>
                                 <div class="ps-1">
                                     <h6>{{ $formattedmasteruangs }}</h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-xxl-4 col-lg-6">
                     <div class="card info-card sales-card">
                         <div id="filter-pembelian" class="filter">
                             <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                             <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                 <li class="dropdown-header text-start">
                                     <h6>Filter</h6>
                                 </li>
                                 <li><a class="dropdown-item" data-filter="todayPembelian">Hari ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_monthPembelian">Bulan ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_yearPembelian">Tahun ini</a></li>
                             </ul>
                         </div>
                         <div id="pembelian-container" class="card-body">
                             <h5 class="card-title">Pembelian <span>| Hari ini</span></h5>
                             <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                                     <a href="{{ route('index.pembelian') }}" class="ri-shopping-cart-2-fill text-white">
                                     </a>
                                 </div>
                                 <div class="ps-3">
                                     <h6 id="pembelian">{{ $totalPembelianPerHari }}</h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-xxl-4 col-lg-6">
                     <div class="card info-card revenue-card">
                         <div id="filter-penjualan" class="filter">
                             <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                             <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                 <li class="dropdown-header text-start">
                                     <h6>Filter</h6>
                                 </li>
                                 <li><a class="dropdown-item" data-filter="todayPenjualan">Hari ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_monthPenjualan">Bulan ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_yearPenjualan">Tahun ini</a></li>
                             </ul>
                         </div>
                         <div id="penjualan-container" class="card-body">
                             <h5 class="card-title">Penjualan <span>| Hari ini</span></h5>
                             <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger">
                                     <a href="{{ route('index.penjualan') }}" class="ri-store-fill text-white"></a>
                                     <i></i>
                                 </div>
                                 <div class="ps-3">
                                     <h6 id="penjualan">{{ $totalPenjualanPerHari }}</h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-xxl-4 col-lg-6">
                     <div class="card info-card revenue-card">
                         <div class="filter">
                             <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                             <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                 <li class="dropdown-header text-start">
                                     <h6>Filter</h6>
                                 </li>
                                 <li><a class="dropdown-item" data-filter="todayPendapatan">Hari ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_monthPendapatan">Bulan ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_yearPendapatan">Tahun ini</a></li>
                             </ul>
                         </div>
                         <div id="pendapatan-container" class="card-body">
                             <h5 class="card-title">Pendapatan <span>| Hari ini</span></h5>
                             <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-dark">
                                     <i class="bi bi-briefcase text-white"></i>
                                 </div>
                                 <div class="ps-1">
                                     <h6 id="pendapatan">{{ $formatpendapatanhari }}</h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-xxl-4 col-lg-6">
                     <div class="card info-card customers-card">
                         <div class="filter">
                             <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                             <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                 <li class="dropdown-header text-start">
                                     <h6>Filter</h6>
                                 </li>
                                 <li><a class="dropdown-item" data-filter="todayPengeluaran">Hari ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_monthPengeluaran">Bulan ini</a></li>
                                 <li><a class="dropdown-item" data-filter="this_yearPengeluaran">Tahun ini</a></li>
                             </ul>
                         </div>
                         <div id="pengeluaran-container" class="card-body">
                             <h5 class="card-title">Pengeluaran <span>| Hari ini</span></h5>

                             <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info">
                                     <i class="bi bi-cash text-white"></i>
                                 </div>
                                 <div class="ps-1">
                                     <h6 id="pengeluaran">{{ $formatpengeluaranhari }}</h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-12">
                     <div class="card top-selling overflow-auto">
                         <div class="card-body pb-0">
                             <h5 class="card-title">Penjualan Terbanyak <span>| Perbulan</span></h5>
                             <div class="table-responsive">
                                 <table class="table table-borderless">
                                     <thead>
                                         <tr>
                                             <th scope="col">Gambar</th>
                                             <th scope="col">Produk</th>
                                             <th scope="col">Harga Jual</th>
                                             <th scope="col">Jumlah</th>
                                             <th scope="col">Total Harga</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($penjualan_terbanyak as $item)
                                             <tr>
                                                 <th><img width="50" height="40px" src=" {{ asset('gambar_produk/' . $item->produks->gambar_produk ?? '-') }}" alt="Preview Gambar"></th>
                                                 <td>{{ $item->produks->nama_produk ?? '-' }}</td> <!-- Nama Produk -->
                                                 <td>Rp {{ number_format($item->produks->harga_jual, 0, ',', '.' ?? '-') }}</td> <!-- Harga Produk -->
                                                 <td class="fw-bold">{{ $item->total_jumlah ?? '-' }}</td> <!-- Jumlah Terjual -->
                                                 <td>Rp {{ number_format($item->produks->harga_jual * $item->total_jumlah, 0, ',', '.' ?? '-') }}</td> <!-- Total Harga -->
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     @include('script_dash')
 @endsection
