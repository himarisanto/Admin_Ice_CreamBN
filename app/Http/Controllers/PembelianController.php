<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\HistoriUang;
use App\Models\Ice;
use App\Models\MasterUang;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PembelianController extends Controller
{
    function index()
    {
        $pembelians = Pembelian::latest()->paginate(12);
        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');
        return view('pembelian.index', compact('pembelians', 'formattedmasteruangs'));
    }

    function create()
    {
        $produks = Ice::all();
        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');
        return view('pembelian.create', compact('produks', 'formattedmasteruangs'));
    }

    public function store(Request $request)
    {
        try {
            $validasi = $request->validate([
                'nota'  => 'required|string',
                'tanggal_transaksi' => 'required|date',
                'type_pembayaran' => 'required|string',
                'total_produk' => 'required|numeric',
                'total_bonus' => 'nullable|numeric',
                'grand_total' => 'required|numeric',
                'pembayaran' => 'required|numeric',
                'kembalian' => 'required|numeric',
                'keterangan'    => 'nullable|string',
                'kode_produk.*' => 'required|string',
                'jumlah_masuk.*' => 'required|numeric',
                'bonus.*' => 'nullable|numeric',
                'harga_beli.*' => 'required|numeric',
                'total_harga.*' => 'required|numeric',
            ]);

            // Mengurangi nilai master_uang di model MasterUang
            $masterUang = MasterUang::first();
            if (!$masterUang) {
                return back()->with('warning', 'Master Uang tidak ditemukan');
            }

            if ($masterUang->master_uang < $request->grand_total) {
                return back()->with('warning', 'Total pembelian tidak boleh melebihi Uang Kas');
            }
            if ($masterUang) {
                $masterUang->decrement('master_uang', $request->grand_total);
            }

            // Simpan data pembelian
            $pembelian = Pembelian::create([
                'nota' => $validasi['nota'],
                'tanggal_transaksi' => $validasi['tanggal_transaksi'],
                'type_pembayaran' => $validasi['type_pembayaran'],
                'total_produk' => $validasi['total_produk'],
                'total_bonus' => $validasi['total_bonus'],
                'grand_total' => $validasi['grand_total'],
                'pembayaran' => $validasi['pembayaran'],
                'kembalian' => $validasi['kembalian'],
                'keterangan' => $validasi['keterangan'],
            ]);

            // Simpan detail pembelian
            foreach ($validasi['kode_produk'] as $key => $kodeProduk) {
                $bonus = $validasi['bonus'][$key] ?? 0;
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'kode_produk' => $kodeProduk,
                    'jumlah_masuk' => $validasi['jumlah_masuk'][$key],
                    'bonus' => $bonus,
                    'harga_beli' => $validasi['harga_beli'][$key],
                    'total_harga' => $validasi['total_harga'][$key],
                ]);

                // Mengupdate stok pada model Ice
                $produk = Ice::where('kode_produk', $kodeProduk)->first();
                if ($produk) {
                    $produk->stok += $validasi['jumlah_masuk'][$key] + $bonus;
                    $produk->save();
                }
            }

            // Menyimpan data ke model HistoriUang
            HistoriUang::create([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'nota' => $request->nota,
                'type' => 'Pengeluaran',
                'kategori' => 'Pembelian',
                'jumlah_uang' => $request->grand_total
            ]);


            return redirect()->route('index.pembelian')
                ->with('message', 'Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Fungsi untuk menampilkan laporan pembelian tanpa filter
    public function laporan_pembelian(Request $request)
    {
        $query = Pembelian::query();

        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            return redirect()->route('laporan.pembelian')->with('message', 'Filter sudah di reset');
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
            $pembelians = $query->paginate($entries)->appends($request->except('page'));
        } else {
            $pembelians = $query->simplePaginate($query->count())->appends($request->except('page'));
        }

        // Hitung jumlah data yang ditemukan
        $totalData = $query->count();

        // Pemeriksaan hasil query
        if ($pembelians->isEmpty()) {
            $errorMessage = '';

            if ($request->filled('search')) {
                $errorMessage = 'Tidak ada hasil pencarian dari \'' . $request->search . '\'';
            } elseif ($request->filled('dari') && $request->filled('hingga')) {
                $fromDate = Carbon::parse($request->dari)->format('d F Y');
                $toDate = Carbon::parse($request->hingga)->format('d F Y');
                $errorMessage = 'Tidak ada data laporan dari tanggal ' . $fromDate . ' hingga ' . $toDate;
            }

            return response()->view('laporan_pembelian.index', compact('pembelians', 'errorMessage', 'totalData'), $pembelians->isEmpty() ? 404 : 200);
        }

        return view('laporan_pembelian.index', compact('pembelians', 'totalData'));
    }
    function print_pembelian($id)
    {
        $pembelian = Pembelian::find($id);
        // dd($pembelian);
        return view('laporan_pembelian.print_pembelian', compact('pembelian'));
    }
}
