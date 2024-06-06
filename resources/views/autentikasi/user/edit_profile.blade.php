<div class="tab-pane fade profile-edit pt-3" id="profile-edit">
    @foreach ($profiles as $data)
        <form method="POST" action="{{ route('store.profile') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="foto_profil" class="col-md-4 col-lg-3 col-form-label"></label>
                <div class="col-md-8 col-lg-9">
                    @isset($data->foto_profil)
                        <img src="{{ asset('/profil_user/' . $data->foto_profil) }}" id="preview2" alt="Profile">
                    @else
                        <img src="{{ asset('/template/assets/img/profile-img.jpg') }}" id="preview2" alt="Profile">
                    @endisset
                </div>
            </div>
            <div class="row mb-3">
                <label for="foto_profil" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                <div class="col-md-8 col-lg-9">
                    <input name="foto_profil" id="foto_profil" type="file" onchange="lihatImage()" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="nama_lengkap" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                <div class="col-md-8 col-lg-9">
                    <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control" required value="{{ $data->nama_lengkap ?? '-' }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                <div class="col-md-8 col-lg-9">
                    <input name="job" type="text" id="job" class="form-control" required value="{{ $data->job ?? '-' }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="wa" class="col-md-4 col-lg-3 col-form-label">WhatsApp <i class="ri-whatsapp-line"></i></label>
                <div class="col-md-8 col-lg-9">
                    <div class="input-group input-group-alternative">
                        <span class="input-group-text">+62</span>
                        <input name="wa" type="number" id="wa" class="form-control" required value="{{ $data->wa ?? '-' }}">
                    </div>

                </div>
            </div>
            <div class="row mb-3">
                <label for="tentang" class="col-md-4 col-lg-3 col-form-label">Tentang</label>
                <div class="col-md-8 col-lg-9">
                    <textarea name="tentang" id="tentang" class="form-control">{{ $data->tentang }}</textarea>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    @endforeach

</div>
<script>
    function lihatImage() {
        // Ambil elemen input file
        var input = document.getElementById('foto_profil');

        // Ambil elemen untuk menampilkan preview
        var preview = document.getElementById('preview2');

        // Setelah pemilihan berkas, tampilkan gambar yang dipilih
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Tampilkan gambar
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
