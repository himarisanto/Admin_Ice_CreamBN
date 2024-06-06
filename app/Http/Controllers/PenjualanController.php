<?php

namespace App\Http\Controllers;

use App\Models\BayarHutang;
use App\Models\DetailPenjualan;
use App\Models\HistoriUang;
use App\Models\Ice;
use App\Models\MasterUang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    function index()
    {
        // Mengambil data penjualan dengan relasi bayarHutangs dan membatasi 12 data per halaman
        $penjualans = Penjualan::with('bayarHutangs')->latest()->paginate(12);

        // Mengambil nilai master uang pertama
        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');

        // Mengambil total pembayaran hutang untuk setiap penjualan
        $totalbayarhutang = BayarHutang::selectRaw('penjualan_id, sum(bayar) as total')
        ->groupBy('penjualan_id')
        ->pluck('total', 'penjualan_id');

        // Mengambil nilai grand_total dari setiap penjualan
        $grandTotalPenjualan = Penjualan::pluck('grand_total', 'id');

        // Debugging: Mencetak total bayar hutang dan grand total penjualan untuk memeriksa nilai
        // dd($totalbayarhutang, $grandTotalPenjualan);

        return view('penjualan.index', compact('penjualans', 'formattedmasteruangs', 'totalbayarhutang'));
    }




    function create()
    {
        $produks = Ice::all();
        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');
        return view('penjualan.create', compact('produks', 'formattedmasteruangs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validasi = $request->validate([
                'nota'  => 'required|string',
                'tanggal_transaksi' => 'required|date',
                'type_pembayaran' => 'required|string',
                'total_produk' => 'required|numeric',
                'grand_total' => 'required|numeric',
                'pembayaran' => ($request->type_pembayaran === 'piutang') ? 'nullable|numeric' : 'required|numeric',
                'kembalian' => ($request->type_pembayaran === 'piutang') ? 'nullable|numeric' : 'required|numeric',
                'keterangan'    => 'nullable|string',
                'kode_produk.*' => 'required|string',
                'jumlah_keluar.*' => 'required|numeric',
                'harga_jual.*' => 'required|numeric',
                'total_harga.*' => 'required|numeric',
            ]);

            $masterUang = MasterUang::first();
            if (!$masterUang) {
                return back()->with('warning', 'Master Uang tidak ditemukan');
            }
            if ($masterUang) {
                $masterUang->increment('master_uang', $request->grand_total);
            }

            // Tentukan nilai pembayaran berdasarkan type_pembayaran
            $pembayaranValue = ($validasi['type_pembayaran'] === 'piutang') ? 0 : $validasi['pembayaran'];
            $kembalianValue = ($validasi['type_pembayaran'] === 'piutang') ? 0 : $validasi['kembalian'];

            // Simpan data penjualan
            $penjualan = Penjualan::create([
                'nota' => $validasi['nota'],
                'tanggal_transaksi' => $validasi['tanggal_transaksi'],
                'type_pembayaran' => $validasi['type_pembayaran'],
                'total_produk' => $validasi['total_produk'],
                'grand_total' => $validasi['grand_total'],
                'pembayaran' => $pembayaranValue,
                'kembalian' => $kembalianValue,
                'keterangan' => $validasi['keterangan'],
            ]);


            // Simpan detail penjualan
            foreach ($validasi['kode_produk'] as $key => $kodeProduk) {
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'kode_produk' => $kodeProduk,
                    'jumlah_keluar' => $validasi['jumlah_keluar'][$key],
                    'harga_jual' => $validasi['harga_jual'][$key],
                    'total_harga' => $validasi['total_harga'][$key],
                ]);

                // Mengupdate stok pada model Ice
                $produk = Ice::where('kode_produk', $kodeProduk)->first();
                if ($produk) {
                    $produk->stok -= $validasi['jumlah_keluar'][$key];
                    $produk->save();
                }
            }
            // Menyimpan data ke model HistoriUang
            HistoriUang::create([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'nota' => $request->nota,
                'type' => 'Pemasukan',
                'kategori' => 'Penjualan',
                'jumlah_uang' => $request->grand_total
            ]);

            return redirect()->route('index.penjualan')
                ->with('message', 'penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    function laporan_penjualan(Request $request)
    {
        $query = Penjualan::query();

        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            return redirect()->route('laporan.penjualan')->with('message', 'Filter sudah di reset');
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('dari') && $request->filled('hingga')) {
            $query->whereBetween('tanggal_transaksi', [$request->dari, $request->hingga]);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('nota', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan urutan tanggal transaksi
        $urutan = $request->input('entri');
        switch ($urutan) {
            case 'baru-lama':
                $query->orderBy('tanggal_transaksi', 'desc');
                break;
            case 'lama-baru':
                $query->orderBy('tanggal_transaksi', 'asc');
                break;
            default:
                // default order jika tidak ada pilihan yang dipilih
                $query->orderBy('tanggal_transaksi', 'desc');
                break;
        }

        // Ambil data dengan pagination
        $entries = $request->input('entri', 10); // Menggunakan paginasi default 10
        $entries = ($entries != 'all') ? (int) $entries : 'all'; // Konversi ke integer jika bukan 'all'

        if ($entries != 'all') {
            $penjualans = $query->paginate($entries)->appends($request->except('page'));
        } else {
            $penjualans = $query->simplePaginate($query->count())->appends($request->except('page'));
        }

        // Hitung jumlah data yang ditemukan
        $totalData = $query->count();

        // Pemeriksaan hasil query
        if ($penjualans->isEmpty()) {
            $errorMessage = '';

            if ($request->filled('search')) {
                $errorMessage = 'Tidak ada hasil pencarian dari \'' . $request->search . '\'';
            } elseif ($request->filled('dari') && $request->filled('hingga')) {
                $fromDate = Carbon::parse($request->dari)->format('d F Y');
                $toDate = Carbon::parse($request->hingga)->format('d F Y');
                $errorMessage = 'Tidak ada data laporan dari tanggal ' . $fromDate . ' hingga ' . $toDate;
            }

            return response()->view('laporan_penjualan.index', compact('penjualans', 'errorMessage', 'totalData'), $penjualans->isEmpty() ? 404 : 200);
        }

        return view('laporan_penjualan.index', compact('penjualans', 'totalData'));
    }

    public function print_harian(Request $request)
    {
        // Ambil filter dari sesi jika ada
        $selectedDate = $request->session()->get('selected_date');
        $searchKeyword = $request->session()->get('search_keyword');

        // Jika filter tidak ada di sesi, gunakan default (tanggal hari ini)
        $tanggal = $selectedDate ? Carbon::parse($selectedDate)->format('Y-m-d') : now()->format('Y-m-d');

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
            ->get(); // Mengambil semua data, karena ini akan dicetak

        // Jika tidak ada hasil, Anda dapat menampilkan pesan atau mengarahkan kembali ke halaman sebelumnya
        if ($harian->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk dicetak.');
        }

        // Kembalikan view cetak dengan data yang diperlukan
        return view('rekapan.print_harian', compact('harian', 'selectedDate', 'searchKeyword', 'tanggal'));
    }

    public function print_bulanan(Request $request)
    {
        // Peroleh bulan yang dipilih dari session
        $selectedMonth = $request->session()->get('selected_month');
        $formatbulan = Carbon::parse($selectedMonth)->translatedFormat('F Y');
        // Query untuk mencari data berdasarkan bulan yang dipilih
        $query = DetailPenjualan::whereHas('relasipenjualan', function ($query) use ($selectedMonth) {
            $query->whereMonth('tanggal_transaksi', Carbon::parse($selectedMonth)->month);
        });

        // Ambil kata kunci pencarian jika ada
        $searchKeyword = $request->session()->get('search_keyword');

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
            ->get();
        // Jika tidak ada hasil, Anda dapat menampilkan pesan atau mengarahkan kembali ke halaman sebelumnya
        if ($bulanan->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk dicetak.');
        }
        // Load view cetak bulanan dan kirimkan data yang diperlukan
        return view('rekapan.print_bulanan', compact('bulanan', 'searchKeyword', 'selectedMonth', 'formatbulan'));
    }
    function print_penjualan($id)
    {
        $penjualan = Penjualan::find($id);
        // dd($penjualan);
        return view('laporan_penjualan.print_penjualan', compact('penjualan'));
    }
}
