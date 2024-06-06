<?php

namespace App\Http\Controllers;

use App\Models\HistoriUang;
use App\Models\MasterUang;
use App\Models\PengeluaranKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PengeluaranKhususController extends Controller
{
    function index(Request $request)
    {
        $keluarkhusus = PengeluaranKhusus::latest();

        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            return redirect()->route('index.pengeluarankhusus')->with('message', 'Filter sudah di reset');
        }

        $counter = 0;

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $searchQuery = $request->search;
            $keluarkhusus = $keluarkhusus->where('oleh', 'like', '%' . $searchQuery . '%')
                ->orWhere('nominal', 'like', '%' . $searchQuery . '%');
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('dari') && $request->filled('hingga')) {
            $keluarkhusus->whereBetween('tanggal_transaksi', [$request->dari, $request->hingga]);
        }

        // Menghitung jumlah item yang cocok dengan kriteria pencarian atau rentang tanggal
        $totalItems = $keluarkhusus->count();

        // Menentukan jumlah halaman berdasarkan jumlah item
        $perPage = $request->filled('search') || ($request->filled('dari') && $request->filled('hingga')) ? $totalItems : 10;

        // Mengatur nilai pagination
        $keluarkhusus = $keluarkhusus->paginate($perPage);

        // Periksa apakah hasil pencarian atau hasil rentang tanggal kosong
        if (($request->filled('search') || ($request->filled('dari') && $request->filled('hingga'))) && $keluarkhusus->isEmpty()) {
            if ($request->filled('search')) {
                $message = 'Tidak ada hasil pencarian untuk "' . $request->search . '"';
            } elseif ($request->filled('dari') && $request->filled('hingga')) {
                $fromDate = Carbon::parse($request->dari)->format('d F Y');
                $toDate = Carbon::parse($request->hingga)->format('d F Y');
                $message = 'Tidak ada pengeluaran khusus dari "' . $fromDate . '" hingga "' . $toDate . '"';
            }
            return view('pengeluaran_khusus.index')->with('keluarkhusus', $keluarkhusus)
                ->with('counter', 0)
                ->with('warning', $message);
        }

        return view('pengeluaran_khusus.index', compact('keluarkhusus', 'counter'));
    }




    function store(Request $request)
    {
        // Mengurangi nilai master_uang di model MasterUang
        $masterUang = MasterUang::first();

        if ($masterUang->master_uang < $request->nominal) {
            return redirect()->back()->with('warning', 'Data pengeluaran khusus tidak boleh melebihi uang kas.');
        }
        $request->validate([
            'tanggal_transaksi' => 'date|required',
            'oleh'              => 'required|string',
            'nominal'           => 'required|numeric',
            'keperluan'         => 'nullable|string'
        ]);
        // Memeriksa apakah panjang dari keperluan melebihi 255 karakter
        if (strlen($request->keperluan) > 255) {
            return back()->with('warning', 'Keperluan tidak boleh melebihi 255 karakter');
        }

        PengeluaranKhusus::create($request->all());
        // Menyimpan data ke model HistoriUang
        HistoriUang::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nota' => '-',
            'type' => 'Pengeluaran',
            'kategori' => 'Pengeluaran khusus',
            'jumlah_uang' => $request->nominal
        ]);

        if ($masterUang) {
            $masterUang->decrement('master_uang', $request->nominal);
        }
        return redirect()->back()->with('message', 'Data pengeluaran khusus berhasil di tambahkan.');
    }
}
