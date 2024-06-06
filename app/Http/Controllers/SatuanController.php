<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::latest()->paginate(10);
        return view('satuan.index', compact('satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan.*' => 'required|string',
            'keterangan.*' => 'string|nullable',
        ]);

        $namaSatuan = $request->input('nama_satuan', []);
        $keteranganSatuan = $request->input('keterangan', []);

        $existingSatuan = DB::table('satuans')->whereIn('nama_satuan', $namaSatuan)->pluck('nama_satuan')->toArray();

        $validDataToInsert = [];
        $invalidData = [];

        // Memisahkan data yang valid dan tidak valid
        foreach ($namaSatuan as $index => $nama) {
            if (!in_array($nama, $existingSatuan)) {
                $validDataToInsert[] = [
                    'nama_satuan' => $nama,
                    'keterangan' => $keteranganSatuan[$index] ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            } else {
                $invalidData[] = $nama;
            }
        }

        if (!empty($validDataToInsert)) {
            DB::table('satuans')->insert($validDataToInsert);
        }

        if (!empty($invalidData)) {
            $message = 'Data satuan ' . implode(', ', $invalidData) . ' sudah ada';
            return redirect()->back()->with('warning', $message);
        }

        return redirect()->back()->with('message', 'Data satuan berhasil dibuat');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $satuan = Satuan::find($id); // Cari model Satuan berdasarkan ID

        if (!$satuan) {
            return redirect()->back()->with('error', 'Data satuan tidak ditemukan');
        }

        $namaSatuanSebelumnya = $satuan->nama_satuan; // Simpan nama satuan sebelum update

        $satuan->update([
            'nama_satuan' => $request->input('nama_satuan'),
            'keterangan' => $request->input('keterangan'),
            'updated_at' => Carbon::now() // Set updated_at menjadi waktu saat ini
        ]);

        return redirect()->back()->with('message', "Satuan ($namaSatuanSebelumnya) berhasil diperbarui menjadi ({$satuan->nama_satuan})");
    }



    public function destroy($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            return redirect()->back()->with('error', 'Data satuan tidak ditemukan');
        }

        $namaSatuan = $satuan->nama_satuan; // Mengambil nama satuan dari objek $satuan

        $satuan->delete();

        return redirect()->back()->with('message', "Data satuan ($namaSatuan) berhasil dihapus");
    }

    public function hapus_terpilih(Request $request)
    {
        // Validasi input
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'required|integer|exists:satuans,id', // Pastikan semua ID ada di tabel satuan
        ]);

        // Ambil array dari selected_ids
        $selectedIds = $request->input('selected_ids');

        // Hitung jumlah satuan yang akan dihapus
        $jumlahSatuan = count($selectedIds);

        // Hapus semua satuan dengan ID yang ada dalam array $selectedIds
        Satuan::whereIn('id', $selectedIds)->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('message', "Satuan terpilih ($jumlahSatuan) berhasil dihapus");
    }


}
