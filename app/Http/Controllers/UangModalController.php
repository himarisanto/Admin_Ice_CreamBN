<?php

namespace App\Http\Controllers;

use App\Models\HistoriUang;
use App\Models\MasterUang;
use App\Models\UangModal;
use Illuminate\Http\Request;

class UangModalController extends Controller
{
    function index()
    {
        $uangmodals = UangModal::latest()->paginate(10);

        // Menghitung total nominal_uang dari model UangModal
        $totalmodal = UangModal::sum('nominal_uang');

        // Format totalmodal menjadi format mata uang Rupiah
        $formattedTotalModal = 'Rp ' . number_format($totalmodal, 0, ',', '.');

        $masteruangs = MasterUang::pluck('master_uang')->first();
        $formattedmasteruangs = 'Rp ' . number_format($masteruangs, 0, ',', '.');

        return view('uang_modal.index', compact('uangmodals', 'formattedmasteruangs', 'formattedTotalModal'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal_simpan' => 'required|date',
            'nominal_uang'   => 'required|numeric',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        // Membuat transaksi uang modal baru
        $uangModal = UangModal::create($request->all());

        // Menambahkan nominal_uang ke master_uang yang ada
        MasterUang::first()->increment('master_uang', $uangModal->nominal_uang);

        // Menyimpan data ke model HistoriUang
        HistoriUang::create([
            'tanggal_transaksi' => $request->tanggal_simpan,
            'nota' => '-',
            'type' => 'Tambah modal',
            'kategori' => 'Tambah modal',
            'jumlah_uang' => $uangModal->nominal_uang
        ]);

        return redirect()->back()->with('message', 'Uang modal berhasil di tambahkan');
    }

    function destroy($id)
    {
        $uangModal = UangModal::find($id);
        $nominal = $uangModal->nominal_uang;

        // Format nominal menjadi Rupiah
        $formattedNominal = "Rp " . number_format($nominal, 0, ',', '.');
        // Mengurangi nilai master_uang di model MasterUang
        $masterUang = MasterUang::first();
        if ($masterUang) {
            $masterUang->decrement('master_uang', $nominal);
        }
        // Menyimpan data ke model HistoriUang
        HistoriUang::create([
            'tanggal_transaksi' => now(),
            'nota' => '-',
            'type' => 'Penghapusan modal',
            'kategori' => 'Penghapusan modal',
            'jumlah_uang' => $nominal
        ]);
        $uangModal->delete();

        return redirect()->back()->with('message', "{$formattedNominal} berhasil di hapus dari modal uang");
    }

    public function hapus_terpilih(Request $request)
    {
        // Validasi input
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'required|integer|exists:uang_modals,id', // Pastikan semua ID ada di tabel satuan
        ]);

        // Ambil array dari selected_ids
        $selectedIds = $request->input('selected_ids');

        // Ambil data UangModal berdasarkan selected_ids
        $uangModals = UangModal::whereIn('id', $selectedIds)->get();

        // Hitung jumlah satuan yang akan dihapus
        $jumlahUangModals = $uangModals->count();

        // Hitung total nominal uang yang akan dihapus
        $totalNominal = $uangModals->sum('nominal_uang'); // Anda perlu menyesuaikan nama kolom jika tidak bernama 'nominal'
        $formattedmasteruangs = 'Rp ' . number_format($totalNominal, 0, ',', '.');

        // Mengurangi nilai master_uang di model MasterUang
        $masterUang = MasterUang::first();
        if ($masterUang) {
            $masterUang->decrement('master_uang', $totalNominal);
        }
        // Hapus semua satuan dengan ID yang ada dalam array $selectedIds
        UangModal::whereIn('id', $selectedIds)->delete();

        // Redirect kembali dengan pesan sukses dan total nominal
        return redirect()->back()->with('message', "$jumlahUangModals terpilih berhasil dihapus dengan total nominal $formattedmasteruangs");
    }
}
