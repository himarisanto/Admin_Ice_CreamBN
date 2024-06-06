<!-- Modal -->
<style>
    #plusSatuan .modal-dialog {
        position: fixed;
        top: 0;
        right: 0;
        margin: 20px;
        /* Memberikan jarak 20px dari sisi kanan dan atas */
    }

    #plusSatuan .modal-content {
        width: 400px;
        /* Sesuaikan dengan lebar modal yang Anda inginkan */
        padding: 20px;
        /* Memberikan jarak di dalam konten modal */
    }

    #plusSatuan .modal-body {
        padding: 0;
        /* Menghapus padding dari modal-body */
    }

    #plusSatuan .form-control {
        margin-bottom: 15px;
        /* Memberikan jarak antar input */
    }
</style>
<div class="modal fade" id="plusSatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-route="{{ route('simpan-satuan') }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Misalnya -->
                <form id="satuanForm">
                    <label for="satuanBaru" class="form-controll">Nama Satuan Baru :</label>
                    <input type="text" class="form-control mb-3" id="satuanBaru" name="satuanBaru" required>
                    <div class="text-center">
                        <button type="button" class="btn btn-success" id="simpanSatuan">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.getElementById("PlusSatuan").addEventListener("click", function() {
        // Menampilkan modal saat tombol di-klik
        var plusSatuan = new bootstrap.Modal(document.getElementById('plusSatuan'));
        plusSatuan.show();
    });

    document.getElementById("simpanSatuan").addEventListener("click", function() {
        // Dapatkan URL rute dari data attribute
        var simpanSatuanRoute = document.getElementById('plusSatuan').dataset.route;

        // Dapatkan nilai dari input
        var satuanBaru = document.getElementById("satuanBaru").value;

        // Kirim permintaan POST ke server menggunakan fetch API
        fetch(simpanSatuanRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    satuanBaru: satuanBaru
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Tindakan lanjutan setelah menerima respons dari server, misalnya menampilkan pesan sukses
                alert(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                // Tindakan lanjutan jika terjadi kesalahan, misalnya menampilkan pesan kesal
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });

        // Tutup modal
        var plusSatuan = bootstrap.Modal.getInstance(document.getElementById('plusSatuan'));
        plusSatuan.hide();
    });
</script>