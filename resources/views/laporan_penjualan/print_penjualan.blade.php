<!DOCTYPE html>
<html>

<head>
    <title>Cetak Nota</title>
    <style>
        @page {
            size: auto;
            /* Ukuran halaman otomatis sesuai konten */
            margin: 0;
            /* Menghapus margin default */
        }

        body {
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 60mm;
            /* Sesuaikan dengan lebar kertas printer Anda */
            font-family: Arial, sans-serif;
            padding: 5px;
            font-size: 12px;
            /* Ubah ukuran font menjadi 12px */
            box-sizing: border-box;
            border: 2px solid #000;
        }

        .invoice-header,
        .invoice-footer {
            text-align: center;
        }

        .invoice-header {
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            /* Tambahkan padding-bottom agar lebih besar */
            margin-bottom: 10px;
            /* Tambahkan margin-bottom agar lebih besar */
        }

        .invoice-body {
            margin-top: 10px;
            /* Tambahkan margin-top agar lebih besar */
        }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            /* Ubah padding-bottom menjadi 5px */
            margin-bottom: 5px;
            /* Ubah margin-bottom menjadi 5px */
        }

        .invoice-item div {
            margin-top: 5px;
            width: 30%;
        }

        .invoice-footer {
            border-top: 1px solid #000;
            padding-top: 10px;
            /* Tambahkan padding-top agar lebih besar */
            margin-top: 10px;
            /* Tambahkan margin-top agar lebih besar */
        }

        /* Hanya tampilkan invoice-container saat print */
        @media print {
            body * {
                visibility: hidden;
            }

            .invoice-container,
            .invoice-container * {
                visibility: visible;
            }

            .invoice-container {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2 style="margin: 0; font-size: 14px;">Cafe Bagimu Negeriku</h2>
            <p style="margin: 0; font-size: 12px;">Jalan Palir Raya No.66 - 68, Podorejo, Kec. Ngaliyan</p>
        </div>
        <div class="invoice-body">
            <div style="margin-bottom: 5px;"> <!-- Tambahkan margin-bottom 5px agar jaraknya sama -->
                <strong style="display: inline-block; width: 70px;">Nota </strong> : {{ $penjualan->nota ?? '-' }}
            </div>
            <div style="margin-bottom: 5px;"> <!-- Tambahkan margin-bottom 5px agar jaraknya sama -->
                <strong style="display: inline-block; width: 70px;">Tanggal </strong> :
                @if($penjualan)
                {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('d F Y') ?? '-' }}
                <!-- Memformat tanggal menjadi "tanggal, bulan, tahun" -->
                @else
                {{ '-' }}
                @endif
            </div>
            <div style="margin-bottom: 5px;"> <!-- Tambahkan margin-bottom 5px agar jaraknya sama -->
                <strong style="display: inline-block; width: 70px;">Pembeli </strong> : {{ $penjualan->keterangan ?? '-' }}
            </div>
            <div style="margin-bottom: 8px">
                <strong style="display: inline-block; width: 70px;">Item </strong> :
            </div>
            <div>
                @if($penjualan)
                @foreach ($penjualan->detailPenjualans as $data)
                <div class="invoice-item">
                    <div>{{ $data->produks->nama_produk ?? '-' }}</div>
                    <div>{{ $data->jumlah_keluar ?? '-' }}</div>
                    <div>Rp {{ number_format($data->total_harga, 0, ',', '.') ?? '-' }}</div>
                </div>
                @endforeach
                @else
                <!-- Tampilkan pesan atau informasi jika $penjualan bernilai null -->
                <div>Belum ada data penjualan.</div>
                @endif

            </div>
            <div style="margin-top: 10px">
                <strong style="display: inline-block; width: 70px;">Total</strong> : Rp {{ isset($penjualan) ? number_format($penjualan->grand_total, 0, ',', '.') : '-' }}
            </div>
            <div>
                <strong style="display: inline-block; width: 70px;">Pembayaran</strong> : Rp {{ isset($penjualan) ? number_format($penjualan->pembayaran, 0, ',', '.') : '-' }}
            </div>
            <div>
                <strong style="display: inline-block; width: 70px;">Kembalian </strong> : Rp {{ isset($penjualan) ? number_format($penjualan->kembalian, 0, ',', '.') : '-' }}
            </div>

        </div>
        <div class="invoice-footer">
            <p style="margin: 0; font-size: 12px;">Terima Kasih</p>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>


</html>