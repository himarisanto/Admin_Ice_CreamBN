  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('dashboard') ? '' : 'collapsed' }} @php $title = " Dashboard" @endphp" href="{{ route('dashboard') }}">
                  <i class="bi bi-grid-fill"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
          <li class="nav-item">
              <a class="nav-link  {{ Route::currentRouteNamed('index.satuan') ? '' : 'collapsed' }}" href="{{ route('index.satuan') }}">
                  <i class="bi bi-layers-fill"></i>
                  <span>Daftar Satuan </span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link  {{ Route::currentRouteNamed('index.ice') ? '' : 'collapsed' }}" href="{{ route('index.ice') }}">
                  <i class="ri-inbox-archive-fill"></i>
                  <span>Data Ice Cream</span>
              </a>
          </li>
          <li class="nav-heading">Uang Kas</li>
          <li class="nav-item">
              <a class="nav-link  {{ Route::currentRouteNamed('index.uangmodal') ? '' : 'collapsed' }}" href="{{ route('index.uangmodal') }}">
                  <i class="ri-money-dollar-circle-fill"></i>
                  <span>Uang Kas</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link  {{ Route::currentRouteNamed('index.historiuang') ? '' : 'collapsed' }}" href="{{ route('index.historiuang') }}">
                  <i class="ri-history-fill"></i>
                  <span>Histori Uang</span>
              </a>
          </li>

          <li class="nav-heading">Transaksi</li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.pembelian', 'create.pembelian') ? '' : 'collapsed' }}" href="{{ Route('index.pembelian') }}">
                  <i class="ri-shopping-cart-2-fill"></i>
                  <span>Pembelian Produk</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.penjualan', 'create.penjualan') ? '' : 'collapsed' }}" href="{{ Route('index.penjualan') }}">
                  <i class="ri-store-fill"></i>
                  <span>Penjualan Produk</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.pengeluarankhusus') ? '' : 'collapsed' }}" href="{{ Route('index.pengeluarankhusus') }}">
                  <i class="ri-bank-card-fill"></i>
                  <span>Pengeluaran Khusus</span>
              </a>
          </li>
          <li class="nav-heading">Laporan</li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('laporan.pembelian') ? '' : 'collapsed' }}" href="{{ Route('laporan.pembelian') }}">
                  <i class="ri-file-text-fill"></i>
                  <span>Laporan Pembelian</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('laporan.penjualan') ? '' : 'collapsed' }}" href="{{ Route('laporan.penjualan') }}">
                  <i class="ri-clipboard-fill"></i>
                  <span>Laporan Penjualan</span>
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.rekapan_harian') ? '' : 'collapsed' }}" href="{{ Route('index.rekapan_harian') }}">
                  <i class="ri-health-book-fill"></i>
                  <span>Rekapan Harian</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.rekapan_bulanan') ? '' : 'collapsed' }}" href="{{ Route('index.rekapan_bulanan') }}">
                  <i class="ri-health-book-fill"></i>
                  <span>Rekapan Bulanan</span>
              </a>
          </li>
          <li class="nav-heading">Pengaturan</li>
          <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteNamed('index.user') ? '' : 'collapsed' }} " href="{{ route('index.user') }}">
                  <i class="ri-user-3-fill"></i>
                  <span>Profile</span>
              </a>
          </li>
      </ul>
  </aside>
