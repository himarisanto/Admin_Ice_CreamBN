<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Admin Ice Cream</title>
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

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <div class="d-flex justify-content-center">
                                            <a href="" class="logo d-flex align-items-center w-auto">
                                                <img src="/template/assets/img/logo.png" alt="">
                                                <span class="d-none d-lg-block">Ice Cream</span>
                                            </a>
                                        </div>
                                    </div>
                                    @if (Session::has('warning'))
                                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                            {{ Session::get('warning') }}
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @elseif (Session::has('message'))
                                        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                             {{ Session::get('message') }}
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('store.login') }}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-3-fill"></i></span>
                                                <input type="text" name="username" class="form-control" id="yourUsername" required value="{{ old('username') }}">
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text toggle-password" id="inputGroupPrepend"><i class="ri-lock-2-fill"></i></span>
                                                <input type="password" name="password" class="form-control" id="yourPassword" required value="{{ old('password') }}">
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login <i class="ri-login-box-line"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('#yourPassword');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Ganti ikon sesuai dengan status password
                if (type === 'password') {
                    togglePassword.innerHTML = '<i class="ri-lock-2-fill"></i>';
                } else {
                    togglePassword.innerHTML = '<i class="ri-eye-fill"></i>';
                }
            });
        });
    </script>
</body>

</html>
