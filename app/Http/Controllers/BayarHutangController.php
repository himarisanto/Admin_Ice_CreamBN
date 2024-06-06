<?php

namespace App\Http\Controllers;

use App\Models\BayarHutang;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class BayarHutangController extends Controller
{
    function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'penjualan_id' => 'required|numeric',
            'tanggal_transaksi' => 'required|date',
            'bayar' => 'required|numeric',
            'oleh' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        // Ambil grand total dari penjualan
        $grandTotal = Penjualan::where('id', $request->penjualan_id)->value('grand_total');

        // Hitung jumlah sisa pembayaran
        $jumlahSisa = BayarHutang::where('penjualan_id', $request->penjualan_id)->sum('bayar');

        // Hitung saldo
        $saldo = $grandTotal - $jumlahSisa - $request->bayar;
        if($grandTotal < ($jumlahSisa + $request->bayar)){
            return redirect()->back()->with('warning', 'Jumlah pembayaran melebihi hutang');
        }
     // Buat pembayaran hutang baru
        BayarHutang::create([
            'penjualan_id' => $request->penjualan_id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'bayar' => $request->bayar,
            'oleh' => $request->oleh,
            'sisa' => $saldo,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('message', 'Pembayaran hutang berhasil');
    }

}
