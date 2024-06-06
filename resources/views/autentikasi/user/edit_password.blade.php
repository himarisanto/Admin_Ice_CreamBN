<div class="tab-pane fade password-edit pt-3" id="password-edit">
    <form action="{{ route('change.password') }}" method="POST" enctype="multipart/form-data" id="password-form">
        @csrf
        <div class="row mb-3">
            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
            <div class="col-md-8 col-lg-9">
                <div class="input-group input-group-alternative">
                    <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                    <span class="input-group-text toggle-password"><i class="ri-eye-off-fill"></i></span>
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
            <div class="col-md-8 col-lg-9">
                <div class="input-group input-group-alternative">
                    <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                    <span class="input-group-text toggle-password"><i class="ri-eye-off-fill"></i></span>
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
            <div class="col-md-8 col-lg-9">
                <div class="input-group input-group-alternative">
                    <input name="confirmpassword" type="password" class="form-control" id="confirmPassword" required>
                    <span class="input-group-text toggle-password"><i class="ri-eye-off-fill"></i></span>
                    <div class="invalid-feedback">Please enter your username.</div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary" onclick="validatePassword()" id="submit-btn">Submit</button>
        </div>
    </form>
</div>

<script>
    function validatePassword() {
        // Mendapatkan nilai input password baru dan konfirmasi password
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Memeriksa apakah password konfirmasi sama dengan password baru
        if (newPassword !== confirmPassword) {
            // Menampilkan pesan alert jika password konfirmasi tidak sama dengan password baru
            alert('Konfirmasi password harus sama dengan password baru');
            event.preventDefault(); // Mencegah pengiriman formulir
        } else {
            // Jika password konfirmasi sama dengan password baru, kirim formulir
            document.querySelector('#password-form').submit();
        }
    }

    // Menangani klik pada ikon mata untuk menampilkan/menyembunyikan password
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const input = icon.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.querySelector('i').classList.toggle('ri-eye-off-fill');
            icon.querySelector('i').classList.toggle('ri-eye-2-line');
        });
    });

    // Memeriksa apakah semua input kosong
    const inputs = document.querySelectorAll('input[required]');
    const submitBtn = document.getElementById('submit-btn');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            let isEmpty = false;
            inputs.forEach(input => {
                if (input.value === '') {
                    isEmpty = true;
                }
            });
            if (isEmpty) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        });
    });
</script>
