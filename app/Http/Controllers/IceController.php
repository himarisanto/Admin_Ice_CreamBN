<?php

namespace App\Http\Controllers;

use App\Models\Ice;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class IceController extends Controller
{
    public function index(Request $request)
    {
        // Reset filter
        if ($request->has('reset_filter') && $request->reset_filter == '1') {
            // Hapus filter yang disimpan dalam sesi
            $request->session()->forget(['search_keyword']);
            return redirect()->route('index.ice')->with('message', 'Filter sudah di reset');
        }

        $searchKeyword = $request->session()->get('search_keyword');
        $searchMessage = ""; // Inisialisasi pesan pencarian kosong

        // Ambil kata kunci pencarian jika ada
        if ($request->has('search')) {
            $searchKeyword = $request->input('search');
            $request->session()->put('search_keyword', $searchKeyword);
        }

        // Tentukan jumlah entri per halaman
        $entries = $request->input('entri', 10); // Default 10 jika tidak ada input

        // Tambahkan filter pencarian jika ada
        $icesQuery = Ice::latest();

        if ($searchKeyword) {
            $icesQuery->where('kode_produk', 'LIKE', "%$searchKeyword%")
            ->orWhere('nama_produk', 'LIKE', "%$searchKeyword%");
        }

        // Ambil hasil pencarian
        $ices = ($entries !== 'all') ? $icesQuery->paginate($entries) : $icesQuery->get();

        // Periksa apakah ada hasil pencarian
        $hasResults = $ices->count() > 0;

        // Set pesan pencarian jika tidak ada hasil dan kata kunci pencarian tidak kosong
        if (!$hasResults && $searchKeyword) {
            $searchMessage = "Tidak ada hasil pencarian dari '$searchKeyword'.";
        }

        $satuans = Satuan::all();
        return view('eskrim.index', compact('ices', 'satuans', 'searchKeyword', 'hasResults', 'searchMessage', 'entries'));
    }







    public function store(Request $req)
    {
        $req->validate([
            'kode_produk' => 'required|string',
            'gambar_produk' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'nama_produk'   => 'required|string',
            'satuan_id'    => 'numeric|nullable', // tambahkan exists untuk memeriksa apakah satuan_id ada di database
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'keterangan'    => 'nullable|string|max:255', // tambahkan max untuk membatasi panjang keterangan
        ]);
        $existingKode = Ice::where('kode_produk', $req->kode_produk)->exists();

        if ($existingKode) {
            return redirect()->back()->with('warning', 'Kode produk ' . $req->kode_produk . ' sudah ada.');
        }



        // Inisialisasi variabel $gambarproduk
        $gambarproduk = null;

        // Periksa apakah gambar diunggah
        if ($req->hasFile('gambar_produk')) {
            $gambarbarang = $req->file('gambar_produk');
            $name = time() . '_' . $gambarbarang->getClientOriginalName(); // Nama file unik
            $destinationPath = public_path('/gambar_produk');
            if ($gambarbarang->move($destinationPath, $name)) {
                $gambarproduk = $name; // atur nilai gambarproduk jika gambar berhasil diunggah
            }
        }

        // Mengubah huruf awal dari nama_produk menjadi huruf besar
        $namaProduk = ucfirst($req['nama_produk']);

        // Simpan data ke database
        Ice::create([
            'kode_produk'   => $req['kode_produk'],
            'gambar_produk' => $gambarproduk, // Gunakan $gambarproduk yang sudah diperiksa
            'nama_produk'   => $namaProduk,
            'satuan_id'    => $req['satuan_id'],
            'harga_beli'    => $req['harga_beli'],
            'harga_jual'    => $req['harga_jual'],
            'keterangan'    => $req['keterangan'],
        ]);

        // Redirect atau lakukan sesuatu setelah penyimpanan
        return redirect()->back()->with('message', 'Data produk berhasil disimpan.');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'kode_produk' => 'required|string',
            'gambar_produk' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'nama_produk'   => 'required|string',
            'satuan_id'    => 'numeric|nullable|exists:satuans,id', // tambahkan exists untuk memeriksa apakah satuan_id ada di database
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'keterangan'    => 'nullable|string|max:255', // tambahkan max untuk membatasi panjang keterangan
        ]);

        // Temukan data produk berdasarkan ID
        $ice = Ice::find($id);
        // Periksa apakah ada produk lain dengan kode yang sama kecuali untuk produk yang sedang diperbarui
        $existingKode = Ice::where('kode_produk', $req->kode_produk)
            ->where('id', '!=', $id)
            ->exists();

        if ($existingKode) {
            return redirect()->back()->with('warning', 'Kode produk ' . $req->kode_produk . ' sudah ada.');
        }
        if (!$ice) {
            return redirect()->back()->withErrors(['message' => 'Data produk tidak ditemukan.'])->withInput();
        }

        // Inisialisasi variabel $gambarproduk
        $gambarproduk = $ice->gambar_produk;

        // Periksa apakah gambar baru diunggah
        if ($req->hasFile('gambar_produk')) {
            $gambarbarang = $req->file('gambar_produk');
            $name = time() . '_' . $gambarbarang->getClientOriginalName(); // Nama file unik
            $destinationPath = public_path('/gambar_produk');
            if ($gambarbarang->move($destinationPath, $name)) {
                // Hapus gambar lama jika ada
                if (File::exists(public_path('gambar_produk/' . $gambarproduk))) {
                    File::delete(public_path('gambar_produk/' . $gambarproduk));
                }
                $gambarproduk = $name; // atur nilai gambarproduk jika gambar berhasil diunggah
            }
        }

        // Mengubah huruf awal dari nama_produk menjadi huruf besar
        $namaProduk = ucfirst($req['nama_produk']);

        // Update data produk
        $ice->update([
            'kode_produk'   => $req['kode_produk'],
            'gambar_produk' => $gambarproduk, // Gunakan $gambarproduk yang sudah diperiksa
            'nama_produk'   => $namaProduk,
            'satuan_id'    => $req['satuan_id'],
            'harga_beli'    => $req['harga_beli'],
            'harga_jual'    => $req['harga_jual'],
            'keterangan'    => $req['keterangan'],
        ]);

        // Redirect atau lakukan sesuatu setelah update
        return redirect()->back()->with('message', 'Data produk berhasil diperbarui.');
    }

    function destroy($id)
    {
        $produks = Ice::find($id);

        // Menyimpan nama produk ke dalam variabel
        $namaProduk = $produks->nama_produk;
        $gambarProduk = $produks->gambar_produk;

        // Menghapus gambar produk dari folder public
        if ($gambarProduk && file_exists(public_path('gambar_produk/' . $gambarProduk))) {
            unlink(public_path('gambar_produk/' . $gambarProduk));
        }

        $produks->delete();

        return redirect()->back()->with('message', 'Data ' . $namaProduk . ' berhasil dihapus.');
    }

    public function storeSatuan(Request $request)
    {
        // Lakukan validasi input
        $request->validate([
            'satuanBaru' => 'required|string',
        ]);

        try {
            // Buat entri satuan baru dalam database
            Satuan::create([
                'nama_satuan' => $request->satuanBaru,
            ]);

            // Jika berhasil, kembalikan respon yang sesuai
            return response()->json(['message' => 'Satuan berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangkap dan keluarkan pesan kesalahan
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function hapus_terpilih(Request $request)
    {
        // Validasi input
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'required|integer|exists:ices,id', // Pastikan semua ID ada di tabel ices
        ]);

        // Ambil array dari selected_ids
        $selectedIds = $request->input('selected_ids');

        // Hitung jumlah ices yang akan dihapus
        $jumlahIce = count($selectedIds);

        // Ambil semua ices yang akan dihapus
        $ices = Ice::whereIn('id', $selectedIds)->get();

        // Hapus file gambar dari setiap ice yang akan dihapus
        foreach ($ices as $ice) {
            // Cek apakah ada gambar yang terkait dengan ice
            if ($ice->gambar_produk) {
                // Buat path lengkap ke file gambar
                $pathToFile = public_path('gambar_produk/' . $ice->gambar_produk);

                // Hapus file gambar jika ada
                if (file_exists($pathToFile)) {
                    unlink($pathToFile);
                }
            }
        }

        // Hapus semua ice dengan ID yang ada dalam array $selectedIds
        Ice::whereIn('id', $selectedIds)->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('message', "Produk terpilih ($jumlahIce) berhasil dihapus beserta gambar");
    }
}
