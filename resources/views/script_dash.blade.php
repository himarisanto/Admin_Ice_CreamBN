<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropdown-item').click(function(e) {
            e.preventDefault();
            var filter = $(this).data('filter');
            var url = '';

            switch (filter) {
                case 'todayPenjualan':
                case 'this_monthPenjualan':
                case 'this_yearPenjualan':
                    url = '{{ route('get_penjualan') }}';
                    break;
                case 'todayPendapatan':
                case 'this_monthPendapatan':
                case 'this_yearPendapatan':
                    url = '{{ route('get_pendapatan') }}';
                    break;
                case 'todayPembelian':
                case 'this_monthPembelian':
                case 'this_yearPembelian':
                    url = '{{ route('get_pembelian') }}';
                    break;
                case 'todayPengeluaran':
                case 'this_monthPengeluaran':
                case 'this_yearPengeluaran':
                    url = '{{ route('get_pengeluaran') }}';
                    break;
                default:
                    break;
            }

            if (url !== '') {
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        filter: filter
                    },
                    success: function(data) {
                        if (url.includes('penjualan')) {
                            $('#penjualan').text(data.total_penjualan);
                            $('#penjualan-container .card-title span').text('| ' + data.title);
                        } else if (url.includes('pendapatan')) {
                            $('#pendapatan').text(data.format_pendapatan);
                            $('#pendapatan-container .card-title span').text('| ' + data.title);
                        } else if (url.includes('pembelian')) {
                            $('#pembelian').text(data.total_pembelian);
                            $('#pembelian-container .card-title span').text('| ' + data.title);
                        } else if (url.includes('pengeluaran')) {
                            $('#pengeluaran').text(data.format_pengeluaran);
                            $('#pengeluaran-container .card-title span').text('| ' + data.title);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
