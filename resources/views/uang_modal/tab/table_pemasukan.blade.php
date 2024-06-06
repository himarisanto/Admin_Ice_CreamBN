<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col" style="width: 50px">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nota</th>
                <th scope="col">Type</th>
                <th scope="col">Kategori</th>
                <th scope="col">Nominal uang</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($historis as $key => $data)
                <tr>
                    <th scope="row">{{ $historis->firstItem() + $key }}</th>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_transaksi ?? '-')->format('d F Y') }}</td>
                    <td>{{ $data->nota ?? '-' }}</td>
                    <td>{{ $data->type ?? '-' }}</td>
                    <td>{{ $data->kategori ?? '-' }}</td>
                    <td>{{ $formattedjumlahuangs[$key] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada histori uang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
<div class="row align-items-center mt-2 mb-2">
    <div class="col-auto">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{ $historis->links() }}
            </ul>
        </nav>
    </div>
</div>
