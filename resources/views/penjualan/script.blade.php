{{-- <script>
    $(document).ready(function() {
        // Variabel untuk menyimpan total harga
        var totalHarga = 0;
        $('.select2').select2();

        // Event listener untuk elemen select dengan class select2
        $('.select2').change(function() {
            // Mendapatkan opsi yang dipilih
            var selectedOption = $(this).find(':selected');

            // Mendapatkan data barang yang dipilih
            var kodeProduk = selectedOption.val();
            var namaProduk = selectedOption.data('nama-produk');
            var hargaJual = selectedOption.data('harga-jual').replace(/\./g, '');
            var gambar = selectedOption.data('gambar');
            var stok = selectedOption.data('stok-produk');

            // Memformat harga jual
            var hargaJualFormatted = formatRupiah(hargaJual);

            // Menambahkan baris baru ke dalam tabel dengan data yang sesuai
            var newRow = `
        <tr data-kode-barang="${kodeProduk}">
            <td>
                <div class="d-flex px-2 py-1">
                    <div>
                        <img src="/gambar_produk/${gambar}" class="avatar avatar-sm me-3" alt="produk" style="width:50px; height: auto;">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">${namaProduk}</h6>
                        <input type="hidden" name="kode_produk[]" class="kode_produk_input" value="${kodeProduk}">
                        <p class="text-xs text-secondary mb-0 stok">Stok : ${stok}</p>
                    </div>
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input required type="text" class="form-control harga_jual" name="harga_jual[]" value="${hargaJualFormatted}">
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <input required type="number" class="form-control jumlah_keluar" name="jumlah_keluar[]">
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold total_harga">Rp 0</span>
                <input type="hidden" name="total_harga[]" class="total_harga_input" value="0">
                <p class="text-xs text-secondary mb-0 total_stok"></p>
            </td>
            <td class="align-middle text-center">
                <button type="button" class="btn btn-danger hapus-baris"><i class="ri-delete-bin-fill"></i></button>
            </td>
        </tr>`;

            $('#listproduk tbody').append(newRow);

            // Menonaktifkan opsi yang dipilih
            selectedOption.prop('disabled', true);
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var formatted = ribuan.join('.').split('').reverse().join('');
            return formatted;
        }

        // Event listener untuk perubahan nilai pada input harga_jual
        $(document).on('input', '.harga_jual', function() {
            var harga_jual = parseFloat($(this).val().replace(/\./g, '')); // Remove dots before parsing
            var jumlah_keluar = parseFloat($(this).closest('tr').find('.jumlah_keluar').val());
            if (!isNaN(harga_jual) && !isNaN(jumlah_keluar)) {
                var total_harga = jumlah_keluar * harga_jual;
                var formatted_total_harga = formatRupiah(total_harga);
                $(this).closest('tr').find('.total_harga').text("Rp " + formatted_total_harga);
                $(this).closest('tr').find('.total_harga_input').val(total_harga);
            } else {
                $(this).closest('tr').find('.total_harga').text("Rp 0");
                $(this).closest('tr').find('.total_harga_input').val(0);
            }

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        // Event listener untuk perubahan nilai pada input jumlah_keluar
        $(document).on('input', '.jumlah_keluar', function() {
            var jumlah_keluar = parseFloat($(this).val());
            var stok = parseFloat($(this).closest('tr').find('.stok').text().replace('Stok : ', ''));
            var harga_jual = parseFloat($(this).closest('tr').find('.harga_jual').val().replace(/\./g,
                '')); // Remove dots before parsing

            if (jumlah_keluar > stok) {
                $('#submitBtn').prop('disabled', true);
                alert('JUMLAH KELUAR MELEBIHI STOK YANG TERSEDIA');
                return; // Berhenti eksekusi kode selanjutnya jika jumlah_keluar lebih besar dari stok
            }

            if (!isNaN(harga_jual) && !isNaN(jumlah_keluar)) {
                var total_harga = jumlah_keluar * harga_jual;
                var formatted_total_harga = formatRupiah(total_harga);
                $(this).closest('tr').find('.total_harga').text("Rp " + formatted_total_harga);
                $(this).closest('tr').find('.total_harga_input').val(total_harga);
                var total_stok = stok - jumlah_keluar;
                $(this).closest('tr').find('.total_stok').text("Total Stok : " + total_stok);
            } else {
                $(this).closest('tr').find('.total_harga').text("Rp 0");
                $(this).closest('tr').find('.total_harga_input').val(0);
            }

            // Menghitung total jumlah keluar dari semua input
            var totalJumlahKeluar = 0;
            $('.jumlah_keluar').each(function() {
                var jumlah_keluar = parseFloat($(this).val());
                jumlah_keluar = isNaN(jumlah_keluar) ? 0 : jumlah_keluar;
                totalJumlahKeluar += jumlah_keluar;
            });

            // Memasukkan nilai totalJumlahKeluar ke input dengan id total_produk
            $('#total_produk').val(totalJumlahKeluar);

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        // Menangani klik pada tombol "Hapus Baris"
        $('#listproduk tbody').on('click', '.hapus-baris', function() {
            // Mengaktifkan kembali opsi yang dihapus dari tabel
            var kode_produk = $(this).closest('tr').data('kode-barang');
            $('select[name="kode_produk"] option[value="' + kode_produk + '"]').prop('disabled', false);

            // Hapus baris saat tombol "Hapus Baris" diklik
            $(this).closest('tr').remove();
            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        function updateTotalHarga() {
            // Reset nilai total harga
            var totalHarga = 0;

            // Loop melalui setiap baris dan menambahkan nilai total harga dari masing-masing baris
            $('#listproduk tbody tr').each(function() {
                // Mendapatkan nilai total harga baris
                var total_harga_baris_text = $(this).find('.total_harga_input').val();

                // Mengonversi teks total harga baris menjadi angka
                var total_harga_baris = parseFloat(total_harga_baris_text.replace(/\./g, ''));

                // Memastikan nilai total_harga_baris adalah angka yang valid, jika tidak, gunakan nilai 0
                total_harga_baris = isNaN(total_harga_baris) ? 0 : total_harga_baris;

                // Menambahkan nilai total harga baris ke totalHarga
                totalHarga += total_harga_baris;
            });

            // Perbarui tampilan total harga
            $('#totalHarga').text("Rp " + formatRupiah(totalHarga));
            $('#grandhargaInput').val(totalHarga);
        }

        $('#pembayaran').on('input', function() {
            // Mendapatkan nilai total harga dari elemen dengan id totalHarga
            var totalHargaText = $('#totalHarga').text();
            var totalHarga = parseFloat(totalHargaText.replace('Rp ', '').replace(/\./g, ''));

            // Pastikan nilai total harga adalah angka yang valid, jika tidak, gunakan nilai 0
            totalHarga = isNaN(totalHarga) ? 0 : totalHarga;

            // Mendapatkan nilai pembayaran dari input pembayaran dan menghilangkan titik
            var pembayaran = parseFloat($(this).val().replace(/\./g, ''));

            // Pastikan nilai pembayaran adalah angka yang valid, jika tidak, gunakan nilai 0
            pembayaran = isNaN(pembayaran) ? 0 : pembayaran;

            // Menghitung kembalian hanya jika nilai total harga dan pembayaran valid
            if (!isNaN(totalHarga) && !isNaN(pembayaran)) {
                // Menghitung kembalian
                var kembalian = pembayaran - totalHarga;

                // Menentukan teks yang akan ditampilkan berdasarkan nilai kembalian
                var kembalianText = "";
                if (kembalian > 0) {
                    kembalianText = "Kembali : " + formatRupiah(kembalian);
                } else if (kembalian < 0) {
                    kembalianText = "Kurang : " + formatRupiah(Math.abs(kembalian));
                } else {
                    kembalianText = "Kembali : Rp 0";
                }

                // Menampilkan kembalian
                $('#kembalian').text(kembalianText);
                $('#kembalianInput').val(kembalian);

                // Mengaktifkan atau menonaktifkan tombol submit berdasarkan nilai kembalian
                if (kembalian < 0) {
                    $('#submitBtn').prop('disabled', true);
                } else {
                    $('#submitBtn').prop('disabled', false);
                }
            }
        });


        // Event listener untuk form submit
        $('#form-transaksi').submit(function(event) {
            // Mendapatkan nilai total harga dari elemen dengan id totalHarga
            var totalHargaText = $('#totalHarga').text();
            var totalHarga = parseFloat(totalHargaText.replace('Rp ', '').replace(/\./g, ''));

            // Pastikan nilai total harga adalah angka yang valid, jika tidak, gunakan nilai 0
            totalHarga = isNaN(totalHarga) ? 0 : totalHarga;

            // Mendapatkan nilai pembayaran dari input pembayaran
            var pembayaran = parseFloat($('#pembayaran').val());

            // Pastikan nilai pembayaran adalah angka yang valid, jika tidak, gunakan nilai 0
            pembayaran = isNaN(pembayaran) ? 0 : pembayaran;

            // Menghentikan pengiriman form jika nilai pembayaran tidak mencukupi
            if (pembayaran < totalHarga) {
                alert('Pembayaran tidak mencukupi!');
                event.preventDefault();
            }
        });
    });
</script> --}}



{{-- yang di pakai --}}
<script>
    $(document).ready(function() {
        // Variabel untuk menyimpan total harga
        var totalHarga = 0;
        $('.select2').select2();

        // Event listener untuk elemen select dengan class select2
        $('.select2').change(function() {
            // Mendapatkan opsi yang dipilih
            var selectedOption = $(this).find(':selected');

            // Mendapatkan data barang yang dipilih
            var kodeProduk = selectedOption.val();
            var namaProduk = selectedOption.data('nama-produk');
            var hargaJual = selectedOption.data('harga-jual').replace(/\./g, '');
            var gambar = selectedOption.data('gambar');
            var stok = selectedOption.data('stok-produk');

            // Memformat harga jual
            var hargaJualFormatted = formatRupiah(hargaJual);

            // Menambahkan baris baru ke dalam tabel dengan data yang sesuai
            var newRow = `
        <tr data-kode-barang="${kodeProduk}">
            <td>
                <div class="d-flex px-2 py-1">
                    <div>
                        <img src="/gambar_produk/${gambar}" class="avatar avatar-sm me-3" alt="produk" style="width:50px; height: auto;">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">${namaProduk}</h6>
                        <input type="hidden" name="kode_produk[]" class="kode_produk_input" value="${kodeProduk}">
                        <p class="text-xs text-secondary mb-0 stok">Stok : ${stok}</p>
                    </div>
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input required type="text" class="form-control harga_jual" name="harga_jual[]" value="${hargaJualFormatted}">
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <input required type="number" class="form-control jumlah_keluar" name="jumlah_keluar[]">
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold total_harga">Rp 0</span>
                <input type="hidden" name="total_harga[]" class="total_harga_input" value="0">
                <p class="text-xs text-secondary mb-0 total_stok"></p>
            </td>
            <td class="align-middle text-center">
                <button type="button" class="btn btn-danger hapus-baris"><i class="ri-delete-bin-fill"></i></button>
            </td>
        </tr>`;

            $('#listproduk tbody').append(newRow);

            // Menonaktifkan opsi yang dipilih
            selectedOption.prop('disabled', true);
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var formatted = ribuan.join('.').split('').reverse().join('');
            return formatted;
        }

        function parseRupiah(numberString) {
            return parseFloat(numberString.replace(/[^0-9,-]+/g, '').replace(/\./g, '').replace(/,/g, '.'));
        }

        // Event listener untuk perubahan nilai pada input harga_jual
        $(document).on('input', '.harga_jual', function() {
            var harga_jual = parseRupiah($(this).val()); // Remove dots before parsing
            var jumlah_keluar = parseFloat($(this).closest('tr').find('.jumlah_keluar').val());
            if (!isNaN(harga_jual) && !isNaN(jumlah_keluar)) {
                var total_harga = jumlah_keluar * harga_jual;
                var formatted_total_harga = formatRupiah(total_harga);
                $(this).closest('tr').find('.total_harga').text("Rp " + formatted_total_harga);
                $(this).closest('tr').find('.total_harga_input').val(total_harga);
            } else {
                $(this).closest('tr').find('.total_harga').text("Rp 0");
                $(this).closest('tr').find('.total_harga_input').val(0);
            }

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        // Event listener untuk perubahan nilai pada input jumlah_keluar
        $(document).on('input', '.jumlah_keluar', function() {
            var jumlah_keluar = parseFloat($(this).val());
            var stok = parseFloat($(this).closest('tr').find('.stok').text().replace('Stok : ', ''));
            var harga_jual = parseRupiah($(this).closest('tr').find('.harga_jual').val()); // Remove dots before parsing

            if (jumlah_keluar > stok) {
                $('#submitBtn').prop('disabled', true);
                alert('JUMLAH KELUAR MELEBIHI STOK YANG TERSEDIA');
                return; // Berhenti eksekusi kode selanjutnya jika jumlah_keluar lebih besar dari stok
            }

            if (!isNaN(harga_jual) && !isNaN(jumlah_keluar)) {
                var total_harga = jumlah_keluar * harga_jual;
                var formatted_total_harga = formatRupiah(total_harga);
                $(this).closest('tr').find('.total_harga').text("Rp " + formatted_total_harga);
                $(this).closest('tr').find('.total_harga_input').val(total_harga);
                var total_stok = stok - jumlah_keluar;
                $(this).closest('tr').find('.total_stok').text("Total Stok : " + total_stok);
            } else {
                $(this).closest('tr').find('.total_harga').text("Rp 0");
                $(this).closest('tr').find('.total_harga_input').val(0);
            }

            // Menghitung total jumlah keluar dari semua input
            var totalJumlahKeluar = 0;
            $('.jumlah_keluar').each(function() {
                var jumlah_keluar = parseFloat($(this).val());
                jumlah_keluar = isNaN(jumlah_keluar) ? 0 : jumlah_keluar;
                totalJumlahKeluar += jumlah_keluar;
            });

            // Memasukkan nilai totalJumlahKeluar ke input dengan id total_produk
            $('#total_produk').val(totalJumlahKeluar);

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        // Menangani klik pada tombol "Hapus Baris"
        $('#listproduk tbody').on('click', '.hapus-baris', function() {
            // Mengaktifkan kembali opsi yang dihapus dari tabel
            var kode_produk = $(this).closest('tr').data('kode-barang');
            $('select[name="kode_produk"] option[value="' + kode_produk + '"]').prop('disabled', false);

            // Hapus baris saat tombol "Hapus Baris" diklik
            $(this).closest('tr').remove();
            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        function updateTotalHarga() {
            // Reset nilai total harga
            var totalHarga = 0;

            // Loop melalui setiap baris dan menambahkan nilai total harga dari masing-masing baris
            $('#listproduk tbody tr').each(function() {
                // Mendapatkan nilai total harga baris
                var total_harga_baris_text = $(this).find('.total_harga_input').val();

                // Mengonversi teks total harga baris menjadi angka
                var total_harga_baris = parseRupiah(total_harga_baris_text);

                // Memastikan nilai total_harga_baris adalah angka yang valid, jika tidak, gunakan nilai 0
                total_harga_baris = isNaN(total_harga_baris) ? 0 : total_harga_baris;

                // Menambahkan nilai total harga baris ke totalHarga
                totalHarga += total_harga_baris;
            });

            // Perbarui tampilan total harga
            $('#totalHarga').text("Rp " + formatRupiah(totalHarga));
            $('#grandhargaInput').val(totalHarga);
        }

        function formatPembayaran(value) {
            const numberString = value.replace(/[^0-9]/g, '').toString();
            const split = numberString.split('');
            const sisa = split.length % 3;
            let rupiah = split.slice(0, sisa).join('');
            const ribuan = split.slice(sisa).join('').match(/\d{3}/g);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        }

        $('#pembayaran').on('input', function() {
            let value = $(this).val();
            $(this).val(formatPembayaran(value));

            var totalHargaText = $('#totalHarga').text();
            var totalHarga = parseRupiah(totalHargaText);

            totalHarga = isNaN(totalHarga) ? 0 : totalHarga;
            var pembayaran = parseRupiah($(this).val());

            pembayaran = isNaN(pembayaran) ? 0 : pembayaran;

            if (!isNaN(totalHarga) && !isNaN(pembayaran)) {
                var kembalian = pembayaran - totalHarga;
                var kembalianText = "";

                if (kembalian > 0) {
                    kembalianText = "Kembali : Rp " + formatRupiah(kembalian);
                } else if (kembalian < 0) {
                    kembalianText = "Kurang : Rp " + formatRupiah(Math.abs(kembalian));
                } else {
                    kembalianText = "Kembali : Rp 0";
                }

                $('#kembalian').text(kembalianText);
            }
            $('#kembalianInput').val(kembalian);

            if (kembalian < 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const masterUangModals = document.getElementById('masteruangmodals');
            const totalHarga = document.getElementById('totalHarga');
            console.log('$masterUangModals');

            const parseRupiah = (rupiah) => {
                return parseInt(rupiah.replace('Rp ', '').replace(/\./g, ''));
            };

            totalHarga.addEventListener('DOMSubtreeModified', function() {
                const masterUangModalsValue = parseRupiah(masterUangModals.textContent);
                const totalHargaValue = parseRupiah(totalHarga.textContent);

                if (totalHargaValue > masterUangModalsValue) {
                    alert('JUMLAH PEMBELIAN MELEBIHI MODAL');
                }
            });
        });

        // Fungsi yang dijalankan saat dokumen dimuat
        $(document).ready(function() {
            // Panggil event listener untuk memperbarui total harga dan pembayaran saat halaman dimuat
            const totalHarga = parseFloat($('#totalHarga').text().replace('Rp ', '').replace(/\./g, ''));
            const pembayaran = parseFloat($('#pembayaran').val().replace(/\./g, ''));
            updateTotalAndPayment(totalHarga, pembayaran);
        });
    });
</script>
