<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/template/assets/img/favicon.png" rel="icon">
    <link href="/template/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/template/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/template/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/template/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/template/assets/vendor/simple-datatables/style.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="/template/assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body onload="window.print()">
    <div class="container-lg px-4">
        <div class="row justify-content-center mt-5">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="container mt-3">
                        <div class="container-title text-center">
                            <h4 class="text-primary"><strong>Rekapan {{ $formatbulan }}</strong></h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <ul>
                                    <li>
                                        <h6>
                                            <strong>Cafe Bagimu Negeriku</strong>
                                        </h6>
                                    </li>
                                    <li>
                                        <h6><strong>Jalan Palir Raya No.66 - 68, Podorejo, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50187</strong></h6>
                                    </li>
                                    <li>
                                        <h6><strong>Admin Ice Cream</strong></h6>
                                    </li>
                                    <li>
                                        <h6 id="tanggal_sekarang"><strong></strong></h6>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row my-2 mx-1 justify-content-center">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead style="background-color:#84B0CA ;" class="text-white">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Harga Jual</th>
                                            <th scope="col">Jumlah Keluar</th>
                                            <th scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalSemuaProduk = 0;
                                            $grandHarga = 0;
                                        @endphp
                                        @foreach ($bulanan as $index => $data)
                                            @php
                                                $totalSemuaProduk += $data->total_jumlah_keluar;
                                                $grandHarga += $data->total_harga_produk;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->kode_produk ?? '-' }} - {{ $data->produks->nama_produk ?? '-' }}</td>
                                                <td>Rp {{ number_format($data->produks->harga_jual, 0, ',', '.' ?? '-') }}</td>
                                                <td>{{ $data->total_jumlah_keluar ?? '-' }}</td>
                                                <td>Rp {{ number_format($data->total_harga_produk, 0, ',', '.' ?? '-') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <ul class="list-unstyled">
                                        <li class="text-muted ms-3"><strong><span class="text-black me-4">Seluruh Produk</span>: {{ $totalSemuaProduk }}</strong></li>
                                        <li class="text-muted ms-3"><strong><span class="text-black me-5">Grand Harga</span>: Rp {{ number_format($grandHarga, 0, ',', '.') }}</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS Files -->
    <script src="/template/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/template/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="/template/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/template/assets/vendor/quill/quill.min.js"></script>
    <script src="/template/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/template/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/template/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/template/assets/js/main.js"></script>
    <script>
        // Mendapatkan tanggal saat ini
        var tanggalSekarang = new Date();

        // Mendefinisikan nama hari dalam Bahasa Indonesia
        var namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

        // Mendapatkan nama hari saat ini
        var hari = namaHari[tanggalSekarang.getDay()];

        // Mendapatkan tanggal
        var tanggal = tanggalSekarang.getDate();

        // Mendefinisikan nama bulan dalam Bahasa Indonesia
        var namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Mendapatkan nama bulan saat ini
        var bulan = namaBulan[tanggalSekarang.getMonth()];

        // Mendapatkan tahun
        var tahun = tanggalSekarang.getFullYear();

        // Format tanggal dalam bentuk string
        var tanggalString = hari + ", " + tanggal + " " + bulan + " " + tahun;

        // Menetapkan tanggal pada elemen HTML dengan ID "tanggal_sekarang"
        document.getElementById("tanggal_sekarang").innerHTML = "<strong>Tanggal Cetak : " + tanggalString + "</strong>";
    </script>
</body>

</html>
