{{-- jadi tapi tidak ada replace --}}
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
            var hargaBeli = selectedOption.data('harga-beli');
            var originalHargaBeli = selectedOption.data(
                'original-harga-beli'); //paggil bilangan hargabeli
            var gambar = selectedOption.data('gambar');
            var stok = selectedOption.data('stok-produk');
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
                        <input required type="text" class="form-control harga_beli" name="harga_beli[]" value="${originalHargaBeli}"> <!-- Use original price -->
                    </div>
                </td>
                <td class="align-middle text-center text-sm">
                    <input required type="number" class="form-control jumlah_masuk" name="jumlah_masuk[]">
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold total_harga ">Rp</span>
                    <input type="hidden" name="total_harga[]" class="total_harga_input">
                     <p class="text-xs text-secondary mb-0 total_stok"> </p>
                </td>
                 <td class="align-middle text-center">
                     <input type="number" class="form-control bonus" name="bonus[]">
                </td>
                <td class="align-middle text-center">
                    <button class="btn btn-danger hapus-baris"><i class="ri-delete-bin-fill"></i></button>
                </td>
            </tr>`;

            $('#listproduk tbody').append(newRow);

            // Menonaktifkan opsi yang dipilih
            selectedOption.prop('disabled', true);
        });

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function calculateTotalPrice(jumlahMasuk, hargaBeli) {
            return jumlahMasuk * hargaBeli;
        }

        function updateTotalAndPayment(totalHarga, pembayaran) {
            $('#totalHarga').text(formatRupiah(totalHarga));
            $('#pembayaran').val(formatRupiah(pembayaran));

            // Menghitung kembalian
            const kembalian = pembayaran - totalHarga;
            $('#kembalian').text(formatRupiah(kembalian));

            // Mengaktifkan atau menonaktifkan tombol submit berdasarkan kembalian
            $('#submitBtn').prop('disabled', kembalian < 0);
        }
        $(document).on('input', '.harga_beli', function() {
            var harga_beli = parseFloat($(this).val());
            var jumlah_masuk = parseFloat($(this).closest('tr').find('.jumlah_masuk').val());
            var total_harga = jumlah_masuk * harga_beli;

            // Mengubah total_harga menjadi format mata uang Rupiah
            var formatted_total_harga = formatRupiah(total_harga);

            $(this).closest('tr').find('.total_harga').text(formatted_total_harga);
            $(this).closest('tr').find('.total_harga_input').val(total_harga);

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });
        $(document).on('input', '.jumlah_masuk', function() {
            var jumlah_masuk = parseFloat($(this).val());
            var harga_beli = parseFloat($(this).closest('tr').find('.harga_beli').val());

            // Menghitung total harga per produk
            var total_harga_produk = jumlah_masuk * harga_beli;

            // Mengubah total harga produk menjadi format mata uang Rupiah
            var formatted_total_harga_produk = formatRupiah(total_harga_produk);

            // Memperbarui tampilan total harga per produk
            $(this).closest('tr').find('.total_harga').text(formatted_total_harga_produk);

            // Hitung total harga keseluruhan
            var total_harga_keseluruhan = 0;
            $('#listproduk tbody tr').each(function() {
                var total_harga_per_produk = parseFloat($(this).find('.total_harga_input')
                    .val());
                total_harga_keseluruhan += total_harga_per_produk;
            });
            // Memperbarui tampilan total harga keseluruhan
            $('#totalHarga').text(formatRupiah(total_harga_keseluruhan));
            $('#grandhargaInput').val(total_harga_keseluruhan);
        });

        // Fungsi yang dijalankan saat dokumen dimuat
        // $(document).ready(function() {
        //     // Panggil event listener untuk memperbarui total harga dan pembayaran saat halaman dimuat
        //     const totalHarga = parseFloat($('#totalHarga').text().replace('Rp ', '').replace('.', ''));
        //     const pembayaran = parseFloat($('#pembayaran').val().replace('Rp ', '').replace('.', ''));
        //     updateTotalAndPayment(totalHarga, pembayaran);
        // });
        $(document).on('input', '.jumlah_masuk, .bonus', function() {
            var jumlah_masuk = parseFloat($(this).closest('tr').find('.jumlah_masuk').val());
            var bonus = parseFloat($(this).closest('tr').find('.bonus').val() ||
                0); // Mengambil nilai bonus, atau 0 jika kosong
            var stok = parseFloat($(this).closest('tr').find('.stok').text().replace('Stok : ', ''));
            var harga_beli = parseFloat($(this).closest('tr').find('.harga_beli').val());

            // Menghitung total harga berdasarkan jumlah_masuk
            var total_harga = jumlah_masuk * harga_beli;
            var total_stok = jumlah_masuk + stok + bonus;

            // Update tampilan dan nilai input total harga
            var formatted_total_harga = formatRupiah(total_harga);
            $(this).closest('tr').find('.total_harga').text(formatted_total_harga);
            $(this).closest('tr').find('.total_stok').text("Total Stok : " + total_stok);
            $(this).closest('tr').find('.total_harga_input').val(total_harga);
            $(this).closest('tr').find('.kode_produk_input').val($(this).closest('tr').data(
                'kode-barang'));

            // Menghitung total jumlah masuk dari semua input
            var totalJumlahMasuk = 0;
            $('.jumlah_masuk').each(function() {
                var jumlah_masuk = parseFloat($(this).val());
                jumlah_masuk = isNaN(jumlah_masuk) ? 0 : jumlah_masuk;
                totalJumlahMasuk += jumlah_masuk;
            });
            var totalJumlahBonus = 0;
            $('.bonus').each(function() {
                var bonus = parseFloat($(this).val());
                bonus = isNaN(bonus) ? 0 : bonus;
                totalJumlahBonus += bonus;
            });
            // Memasukkan nilai totalJumlahMasuk ke input dengan id total_produk
            $('#total_produk').val(totalJumlahMasuk);
            $('#total_bonus').val(totalJumlahBonus);

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
                // Mendapatkan nilai jumlah_masuk dan harga_beli
                var jumlah_masuk = parseFloat($(this).find('.jumlah_masuk').val());
                var harga_beli = parseFloat($(this).find('.harga_beli').val());

                // Menghitung total harga per barang
                var total_harga_barang = jumlah_masuk * harga_beli;

                // Menambahkan total harga per barang ke totalHarga
                totalHarga += total_harga_barang;
            });

            // Perbarui tampilan total harga
            $('#totalHarga').text(formatRupiah(totalHarga));
            $('#grandhargaInput').val(totalHarga);
        }
        // Event listener untuk perubahan nilai pada input pembayaran
        $('#pembayaran').on('input', function() {
            // Mendapatkan nilai total harga dari elemen dengan id totalHarga
            var totalHargaText = $('#totalHarga').text();
            // Menghilangkan 'Rp ' dan mengubah ',' menjadi '' untuk mendapatkan angka total harga
            var totalHarga = parseFloat(totalHargaText.replace('Rp ', '').replace(/[^0-9,-]+/g, '')
                .replace(/,/g, ','));

            // Pastikan nilai total harga adalah angka yang valid, jika tidak, gunakan nilai 0
            totalHarga = isNaN(totalHarga) ? 0 : totalHarga;

            // Mendapatkan nilai pembayaran dari input pembayaran
            var pembayaran = parseFloat($(this).val());

            // Pastikan nilai pembayaran adalah angka yang valid, jika tidak, gunakan nilai 0
            pembayaran = isNaN(pembayaran) ? 0 : pembayaran;

            // Menghitung kembalian hanya jika nilai total harga dan pembayaran valid
            if (!isNaN(totalHarga) && !isNaN(pembayaran)) {
                // Menghitung kembalian
                var kembalian = pembayaran - totalHarga;

                // Menentukan teks yang akan ditampilkan berdasarkan nilai kembalian
                var kembalianText = "";
                if (kembalian > 0) {
                    kembalianText = "Kembali : Rp " + kembalian.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                } else if (kembalian < 0) {
                    kembalianText = "Kurang : Rp " + Math.abs(kembalian).toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                } else {
                    kembalianText = "Kembali : Rp 0";
                }

                // Menampilkan kembalian
                $('#kembalian').text(kembalianText);
            }
            document.getElementById('kembalianInput').value = kembalian;

            // Mengaktifkan atau menonaktifkan tombol submit berdasarkan nilai kembalian
                if (kembalian < 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const masterUangModals = document.getElementById('masteruangmodals');
            const totalHarga = document.getElementById('totalHarga');
            console.log('$masterUangModals'); // Tambahkan baris ini

            // Fungsi untuk menghapus format Rupiah dan mengonversinya menjadi angka
            const parseRupiah = (rupiah) => {
                return parseInt(rupiah.replace('Rp ', '').replace('.', ''));
            };

            // Event listener untuk membandingkan nilai totalHarga dengan masteruangmodals
            totalHarga.addEventListener('DOMSubtreeModified', function() {
                const masterUangModalsValue = parseRupiah(masterUangModals.textContent);
                const totalHargaValue = parseRupiah(totalHarga.textContent);

                if (totalHargaValue > masterUangModalsValue) {
                    alert('JUMLAH PEMBELIAN MELEBIHI MODAL');
                }
            });
        });
    });
</script> --}}



{{-- jadi tapi replacnya koma --}}
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
            var hargaBeli = selectedOption.data('harga-beli');
            var originalHargaBeli = selectedOption.data('original-harga-beli'); //panggil bilangan harga beli
            var gambar = selectedOption.data('gambar');
            var stok = selectedOption.data('stok-produk');
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
                    <input required type="text" class="form-control harga_beli" name="harga_beli[]" value="${originalHargaBeli}">
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <input required type="number" class="form-control jumlah_masuk" name="jumlah_masuk[]">
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold total_harga">Rp</span>
                <input type="hidden" name="total_harga[]" class="total_harga_input">
                <p class="text-xs text-secondary mb-0 total_stok"></p>
            </td>
             <td class="align-middle text-center">
                 <input type="number" class="form-control bonus" name="bonus[]">
            </td>
            <td class="align-middle text-center">
                <button class="btn btn-danger hapus-baris"><i class="ri-delete-bin-fill"></i></button>
            </td>
        </tr>`;

            $('#listproduk tbody').append(newRow);

            // Menonaktifkan opsi yang dipilih
            selectedOption.prop('disabled', true);
        });

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function formatNumber(number) {
            return number.toLocaleString('id-ID').replace(/,/g, '.');
        }

        function parseNumber(numberString) {
            return parseFloat(numberString.replace(/[^0-9,-]+/g, '').replace(/\./g, '').replace(/,/g, '.'));
        }

        function calculateTotalPrice(jumlahMasuk, hargaBeli) {
            return jumlahMasuk * hargaBeli;
        }

        function updateTotalAndPayment(totalHarga, pembayaran) {
            $('#totalHarga').text(formatRupiah(totalHarga));
            $('#pembayaran').val(formatNumber(pembayaran));

            // Menghitung kembalian
            const kembalian = pembayaran - totalHarga;
            $('#kembalian').text(formatRupiah(kembalian));

            // Mengaktifkan atau menonaktifkan tombol submit berdasarkan kembalian
            $('#submitBtn').prop('disabled', kembalian < 0);
        }

        $(document).on('input', '.harga_beli', function() {
            var harga_beli = parseFloat($(this).val());
            var jumlah_masuk = parseFloat($(this).closest('tr').find('.jumlah_masuk').val());
            var total_harga = jumlah_masuk * harga_beli;

            // Mengubah total_harga menjadi format mata uang Rupiah
            var formatted_total_harga = formatRupiah(total_harga);

            $(this).closest('tr').find('.total_harga').text(formatted_total_harga);
            $(this).closest('tr').find('.total_harga_input').val(total_harga);

            // Perbarui total harga setiap kali nilai total harga berubah
            updateTotalHarga();
        });

        $(document).on('input', '.jumlah_masuk', function() {
            var jumlah_masuk = parseFloat($(this).val());
            var harga_beli = parseFloat($(this).closest('tr').find('.harga_beli').val());

            // Menghitung total harga per produk
            var total_harga_produk = jumlah_masuk * harga_beli;

            // Mengubah total harga produk menjadi format mata uang Rupiah
            var formatted_total_harga_produk = formatRupiah(total_harga_produk);

            // Memperbarui tampilan total harga per produk
            $(this).closest('tr').find('.total_harga').text(formatted_total_harga_produk);

            // Hitung total harga keseluruhan
            var total_harga_keseluruhan = 0;
            $('#listproduk tbody tr').each(function() {
                var total_harga_per_produk = parseFloat($(this).find('.total_harga_input')
                .val());
                total_harga_keseluruhan += total_harga_per_produk;
            });
            // Memperbarui tampilan total harga keseluruhan
            $('#totalHarga').text(formatRupiah(total_harga_keseluruhan));
            $('#grandhargaInput').val(total_harga_keseluruhan);
        });

        $(document).on('input', '.jumlah_masuk, .bonus', function() {
            var jumlah_masuk = parseFloat($(this).closest('tr').find('.jumlah_masuk').val());
            var bonus = parseFloat($(this).closest('tr').find('.bonus').val() || 0);
            var stok = parseFloat($(this).closest('tr').find('.stok').text().replace('Stok : ', ''));
            var harga_beli = parseFloat($(this).closest('tr').find('.harga_beli').val());

            var total_harga = jumlah_masuk * harga_beli;
            var total_stok = jumlah_masuk + stok + bonus;

            var formatted_total_harga = formatRupiah(total_harga);
            $(this).closest('tr').find('.total_harga').text(formatted_total_harga);
            $(this).closest('tr').find('.total_stok').text("Total Stok : " + total_stok);
            $(this).closest('tr').find('.total_harga_input').val(total_harga);
            $(this).closest('tr').find('.kode_produk_input').val($(this).closest('tr').data(
                'kode-barang'));

            var totalJumlahMasuk = 0;
            $('.jumlah_masuk').each(function() {
                var jumlah_masuk = parseFloat($(this).val());
                jumlah_masuk = isNaN(jumlah_masuk) ? 0 : jumlah_masuk;
                totalJumlahMasuk += jumlah_masuk;
            });
            var totalJumlahBonus = 0;
            $('.bonus').each(function() {
                var bonus = parseFloat($(this).val());
                bonus = isNaN(bonus) ? 0 : bonus;
                totalJumlahBonus += bonus;
            });

            $('#total_produk').val(totalJumlahMasuk);
            $('#total_bonus').val(totalJumlahBonus);

            updateTotalHarga();
        });

        $('#listproduk tbody').on('click', '.hapus-baris', function() {
            var kode_produk = $(this).closest('tr').data('kode-barang');
            $('select[name="kode_produk"] option[value="' + kode_produk + '"]').prop('disabled', false);

            $(this).closest('tr').remove();
            updateTotalHarga();
        });

        function updateTotalHarga() {
            var totalHarga = 0;

            $('#listproduk tbody tr').each(function() {
                var jumlah_masuk = parseFloat($(this).find('.jumlah_masuk').val());
                var harga_beli = parseFloat($(this).find('.harga_beli').val());

                var total_harga_barang = jumlah_masuk * harga_beli;

                totalHarga += total_harga_barang;
            });

            $('#totalHarga').text(formatRupiah(totalHarga));
            $('#grandhargaInput').val(totalHarga);
        }

        function formatPembayaran(value) {
            const numberString = value.replace(/[^0-9,]/g, '').toString();
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        $('#pembayaran').on('input', function() {
            let value = $(this).val();
            $(this).val(formatPembayaran(value));

            var totalHargaText = $('#totalHarga').text();
            var totalHarga = parseNumber(totalHargaText);

            totalHarga = isNaN(totalHarga) ? 0 : totalHarga;
            var pembayaran = parseNumber($(this).val());

            pembayaran = isNaN(pembayaran) ? 0 : pembayaran;

            if (!isNaN(totalHarga) && !isNaN(pembayaran)) {
                var kembalian = pembayaran - totalHarga;
                var kembalianText = "";

                if (kembalian > 0) {
                    kembalianText = "Kembali : Rp " + kembalian.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                } else if (kembalian < 0) {
                    kembalianText = "Kurang : Rp " + Math.abs(kembalian).toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                } else {
                    kembalianText = "Kembali : Rp 0";
                }

                $('#kembalian').text(kembalianText);
            }
            document.getElementById('kembalianInput').value = kembalian;

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
            const totalHarga = parseFloat($('#totalHarga').text().replace('Rp ', '').replace(/\./g,
            ''));
            const pembayaran = parseFloat($('#pembayaran').val().replace('Rp ', '').replace(/\./g, ''));
            updateTotalAndPayment(totalHarga, pembayaran);
        });
    });
</script>
