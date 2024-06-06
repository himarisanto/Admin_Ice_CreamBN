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


    <!-- Select2 CSS -->
    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    @include('layout.header')
    @include('layout.sidebar')


    <main id="main" class="main">

        <div class="pagetitle">
            <h1>
                @php
                    $title = 'Dashboard';
                @endphp

                @if (Route::currentRouteNamed('dashboard'))
                    Dashboard
                @elseif(Route::currentRouteNamed('index.satuan'))
                    Daftar Satuan
                @elseif(Route::currentRouteNamed('index.ice'))
                @elseif (Route::currentRouteNamed('index.pembelian'))
                    {{-- Produk Masuk --}}
                @elseif (Route::currentRouteNamed('create.pembelian'))
                    <!-- Transaksi Pembelian -->
                @endif
            </h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav> -->
        </div><!-- End Page Title -->

        @include('layout.content')


    </main><!-- End #main -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
</body>

</html>
