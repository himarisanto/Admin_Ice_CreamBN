<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\HistoriUang;
use App\Models\MasterUang;
use App\Models\Pembelian;
use App\Models\PengeluaranKhusus;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');

        // Pembelian
        $totalPembelianPerHari = Pembelian::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('total_produk');
        $totalPembelianPerBulan = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('total_produk');

        $totalPembelianPerTahun = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('total_produk');

        // Penjualan
        $totalPenjualanPerHari = Penjualan::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('total_produk');
        $totalPenjualanPerBulan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('total_produk');

        $totalPenjualanPerTahun = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('total_produk');

        // Pendapatan
        $pendapatanPerHari = Penjualan::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('grand_total');
        $formatpendapatanhari = 'Rp ' . number_format($pendapatanPerHari, 0, ',', '.');

        $pendapatanPerBulan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('grand_total');
        $formatpendapatanbulan =  'Rp ' . number_format($pendapatanPerBulan, 0, ',', '.');

        $pendapatanPerTahun = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('grand_total');
        $formatpendapatantahun =  'Rp ' . number_format($pendapatanPerTahun, 0, ',', '.');

        // Pengeluaran Khusus
        $keluarkhususPerHari = PengeluaranKhusus::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('nominal');
        $keluarkhususPerBulan = PengeluaranKhusus::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('nominal');
        $keluarkhususPerTahun = PengeluaranKhusus::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('nominal');


        // Pengeluaran
        $pengeluaranPerHari = Pembelian::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('grand_total') + $keluarkhususPerHari;
        $formatpengeluaranhari = 'Rp ' . number_format($pengeluaranPerHari, 0, ',', '.');

        $pengeluaranPerBulan = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('grand_total') + $keluarkhususPerBulan;
        $formatpengeluaranbulan =  'Rp ' . number_format($pengeluaranPerBulan, 0, ',', '.');

        $pengeluaranPerTahun = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('grand_total') + $keluarkhususPerTahun;
        $formatpengeluarantahun =  'Rp ' . number_format($pengeluaranPerTahun, 0, ',', '.');


        // Ambil produk terjual terbanyak dari model DetailPenjualan
        $penjualan_terbanyak = DetailPenjualan::select('kode_produk', DB::raw('SUM(jumlah_keluar) as total_jumlah'))
            ->groupBy('kode_produk')
            ->orderByDesc('total_jumlah')
            ->take(5)
            ->get();

        // Load relasi 'produks' untuk setiap produk
        $penjualan_terbanyak->load('produks');



        return view('dashboard', compact(
            'formattedmasteruangs',
            'totalPembelianPerHari',
            'totalPenjualanPerHari',
            'formatpendapatanhari',
            'formatpengeluaranhari',
            'penjualan_terbanyak'
        ));
    }
    public function get_pendapatan(Request $request)
    {
        $filter = $request->input('filter');
        $pendapatan = 0;
        $title = '';

        switch ($filter) {
            case 'todayPendapatan':
                $pendapatan = Penjualan::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('grand_total');
                $title = 'Hari ini';
                break;
            case 'this_monthPendapatan':
                $pendapatan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
                    ->sum('grand_total');
                $title = 'Bulan ini';
                break;
            case 'this_yearPendapatan':
                $pendapatan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->sum('grand_total');
                $title = 'Tahun ini';
                break;
        }

        $format_pendapatan = 'Rp ' . number_format($pendapatan, 0, ',', '.');

        return response()->json([
            'format_pendapatan' => $format_pendapatan,
            'title' => $title
        ]);
    }

    public function get_pengeluaran(Request $request)
    {
        $filter = $request->input('filter');
        $pengeluaran = 0;
        $title = '';

        // Hitung total pengeluaran dari transaksi pembelian
        $totalPembelian = Pembelian::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('grand_total');
        $totalPembelianPerBulan = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('grand_total');
        $totalPembelianPerTahun = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('grand_total');

        // Hitung total pengeluaran dari transaksi pengeluaran khusus
        $keluarkhususPerHari = PengeluaranKhusus::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('nominal');
        $keluarkhususPerBulan = PengeluaranKhusus::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
            ->sum('nominal');
        $keluarkhususPerTahun = PengeluaranKhusus::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
            ->sum('nominal');

        // Hitung total pengeluaran sesuai dengan filter yang dipilih
        switch ($filter) {
            case 'todayPengeluaran':
                $pengeluaran = $totalPembelian + $keluarkhususPerHari;
                $title = 'Hari ini';
                break;
            case 'this_monthPengeluaran':
                $pengeluaran = $totalPembelianPerBulan + $keluarkhususPerBulan;
                $title = 'Bulan ini';
                break;
            case 'this_yearPengeluaran':
                $pengeluaran = $totalPembelianPerTahun + $keluarkhususPerTahun;
                $title = 'Tahun ini';
                break;
        }

        $format_pengeluaran = 'Rp ' . number_format($pengeluaran, 0, ',', '.');

        return response()->json([
            'format_pengeluaran' => $format_pengeluaran,
            'title' => $title
        ]);
    }


    public function get_penjualan(Request $request)
    {
        $filter = $request->input('filter');
        $totalPenjualan = 0;
        $title = '';

        switch ($filter) {
            case 'todayPenjualan':
                $totalPenjualan = Penjualan::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('total_produk');
                $title = 'Hari ini';
                break;
            case 'this_monthPenjualan':
                $totalPenjualan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
                    ->sum('total_produk');
                $title = 'Bulan ini';
                break;
            case 'this_yearPenjualan':
                $totalPenjualan = Penjualan::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->sum('total_produk');
                $title = 'Tahun ini';
                break;
        }

        return response()->json([
            'total_penjualan' => $totalPenjualan,
            'title' => $title
        ]);
    }

    public function get_pembelian(Request $request)
    {
        $filter = $request->input('filter');
        $totalPembelian = 0;
        $title = '';

        switch ($filter) {
            case 'todayPembelian':
                $totalPembelian =  Pembelian::whereDate('tanggal_transaksi', '=', \Carbon\Carbon::now()->toDateString())->sum('total_produk');
                $title = 'Hari ini';
                break;
            case 'this_monthPembelian':
                $totalPembelian = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->whereMonth('tanggal_transaksi', '=', \Carbon\Carbon::now()->month)
                    ->sum('total_produk');
                $title = 'Bulan ini';
                break;
            case 'this_yearPembelian':
                $totalPembelian = Pembelian::whereYear('tanggal_transaksi', '=', \Carbon\Carbon::now()->year)
                    ->sum('total_produk');
                $title = 'Tahun ini';
                break;
        }

        return response()->json([
            'total_pembelian' => $totalPembelian,
            'title' => $title
        ]);
    }



    public function histori()
    {
        $historis = HistoriUang::latest()->paginate(10);

        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');

        $formattedjumlahuangs = [];
        foreach ($historis as $histori) {
            $formattedjumlahuangs[] = 'Rp ' . number_format($histori->jumlah_uang, 0, ',', '.');
        }

        return view('uang_modal.index_histori', compact('historis', 'formattedmasteruangs', 'formattedjumlahuangs'));
    }
    function rekapan_harian(Request $request)
    {
        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            // Hapus filter yang disimpan dalam sesi
            $request->session()->forget(['search_keyword', 'selected_date']);
            return redirect()->route('index.rekapan_harian')->with('message', 'Filter sudah di reset');
        }

        // Ambil filter dari sesi jika ada
        $selectedDate = $request->session()->get('selected_date');
        $searchKeyword = $request->session()->get('search_keyword');

        // Jika filter tidak ada di sesi, gunakan default (tanggal hari ini)
        $tanggal = $selectedDate ? Carbon::parse($selectedDate)->format('Y-m-d') : now()->format('Y-m-d');

        // Ambil tanggal yang dipilih dari input pilih_tanggal jika ada
        if ($request->has('pilih_tanggal')) {
            $selectedDate = $request->input('pilih_tanggal');
            $request->session()->put('selected_date', $selectedDate);
            $tanggal = Carbon::parse($selectedDate)->format('Y-m-d');
        }

        // Ambil kata kunci pencarian jika ada
        if ($request->has('search')) {
            $searchKeyword = $request->input('search');
            $request->session()->put('search_keyword', $searchKeyword);
        }

        // Query untuk mencari data berdasarkan filter yang diterapkan
        $query = DetailPenjualan::whereHas('relasipenjualan', function ($query) use ($tanggal) {
            $query->whereDate('tanggal_transaksi', $tanggal);
        });

        // Tambahkan filter pencarian jika ada
        if ($searchKeyword) {
            $query->where(function ($query) use ($searchKeyword) {
                $query->where('kode_produk', 'like', "%$searchKeyword%")
                    ->orWhereHas('produks', function ($query) use ($searchKeyword) {
                        $query->where('nama_produk', 'like', "%$searchKeyword%");
                    });
            });
        }

        // Ambil data setelah menerapkan filter
        $harian = $query->select(
            'kode_produk',
            \DB::raw('SUM(jumlah_keluar) as total_jumlah_keluar'),
            \DB::raw('SUM(total_harga) as total_harga_produk')
        )
            ->groupBy('kode_produk')
            ->paginate(10); // Mengatur jumlah item per halaman menjadi 10

        // Periksa apakah ada hasil pencarian
        $hasResults = count($harian) > 0;

        // Periksa apakah ada penjualan pada tanggal yang dipilih
        $hasSales = DetailPenjualan::whereHas('relasipenjualan', function ($query) use ($tanggal) {
            $query->whereDate('tanggal_transaksi', $tanggal);
        })->exists();

        // Jika tidak ada hasil pencarian dan tidak ada penjualan pada tanggal yang dipilih
        if (!$hasResults && !$hasSales) {
            $searchMessage = "Tidak ada penjualan pada tanggal ini.";
        } elseif (!$hasResults) { // Jika tidak ada hasil pencarian
            $searchMessage = "Tidak ada hasil pencarian dari '$searchKeyword'.";
        } else {
            $searchMessage = ''; // Jika ada hasil pencarian
        }

        return view(
            'rekapan.harian',
            compact('harian', 'searchMessage', 'searchKeyword', 'selectedDate')
        );
    }


    function rekapan_bulanan(Request $request)
    {
        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            // Kosongkan query builder untuk mereset filter
            $request->session()->forget(['search_keyword', 'selected_month']);
            return redirect()->route('index.rekapan_bulanan')->with('message', 'Filter sudah di reset');
        }

        $tanggal = now()->format('Y-m-d'); // Mengambil tanggal hari ini

        // Ambil bulan yang dipilih dari session jika ada
        $selectedMonth = $request->session()->get('selected_month');

        // Ambil bulan yang dipilih dari input bulan jika tersedia
        $inputMonth = $request->input('bulan');
        if ($inputMonth) {
            // Simpan bulan yang dipilih ke dalam session
            $request->session()->put('selected_month', $inputMonth);
            $selectedMonth = $inputMonth;
            $tanggal = Carbon::parse($selectedMonth)->format('Y-m-d');
        }

        // Cek apakah ada pencarian
        $searchKeyword = $request->input('search');
        if ($searchKeyword) {
            // Simpan kata kunci pencarian ke dalam session
            $request->session()->put('search_keyword', $searchKeyword);
        }

        // Query untuk mencari data berdasarkan kata kunci pencarian dan bulan yang dipilih
        $query = DetailPenjualan::whereHas('relasipenjualan', function ($query) use ($tanggal) {
            $query->whereMonth('tanggal_transaksi', Carbon::parse($tanggal)->month);
        });

        // Jika ada kata kunci pencarian, tambahkan kondisi pencarian
        if ($searchKeyword) {
            $query->where(function ($query) use ($searchKeyword) {
                $query->where('kode_produk', 'like', "%$searchKeyword%")
                    ->orWhereHas('produks', function ($query) use ($searchKeyword) {
                        $query->where('nama_produk', 'like', "%$searchKeyword%");
                    });
            });
        }

        // Ambil data setelah menerapkan filter
        $bulanan = $query->select(
            'kode_produk',
            \DB::raw('SUM(jumlah_keluar) as total_jumlah_keluar'),
            \DB::raw('SUM(total_harga) as total_harga_produk')
        )
            ->groupBy('kode_produk')
            ->paginate(10);

        // Periksa apakah ada hasil pencarian
        $hasResults = count($bulanan) > 0;

        // Periksa apakah ada penjualan pada bulan yang dipilih
        $hasSales = DetailPenjualan::whereHas('relasipenjualan', function ($query) use ($tanggal) {
            $query->whereMonth('tanggal_transaksi', Carbon::parse($tanggal)->month);
        })->exists();

        // Jika tidak ada hasil pencarian dan tidak ada penjualan pada bulan yang dipilih
        if (!$hasResults && !$hasSales) {
            $searchMessage = "Tidak ada data penjualan pada bulan ini.";
        } else {
            $searchMessage = $hasResults ? '' : "Tidak ada hasil pencarian dari '$searchKeyword'";
        }

        return view('rekapan.bulanan', compact('bulanan', 'searchMessage', 'searchKeyword', 'selectedMonth'));
    }
}
