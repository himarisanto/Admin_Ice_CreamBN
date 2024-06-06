<section class="section dashboard">
    @yield('content')
    @if (Session::has('message') || Session::has('error') || Session::has('warning'))
        @php
            $message = Session::get('message');
            $error = Session::get('error');
            $warning = Session::get('warning');
        @endphp

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                setTimeout(function() {
                    @if ($message)
                        Toast.fire({
                            icon: 'success',
                            title: '{{ $message }}'
                        });
                    @elseif ($error)
                        Toast.fire({
                            icon: 'error',
                            title: '{{ $error }}'
                        });
                    @elseif ($warning)
                        Toast.fire({
                            icon: 'warning',
                            title: '{{ $warning }}'
                        });
                    @endif
                }, 1000);
            });
        </script>
    @endif
</section>
