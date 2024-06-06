@extends('layout.master')
@section('content')
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="row gx-4 d-flex justify-content-between">
            <div class="col-auto d-flex align-items-center">
                <a href="#" class="mr-2">
                    <i class="ri-inbox-archive-fill fs-3"></i>
                </a>&nbsp;
                <h5 class="mb-0 mt-0"><strong>Ice Cream</strong></h5>
            </div>
            <div class="col-auto d-flex align-items-center">
                <form action="{{ route('index.ice') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <select class="form-control" name="entri" aria-placeholder="pilih jumlah">
                                <option value="10" {{ request('entri') == '10' ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('entri') == '25' ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('entri') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entri') == '100' ? 'selected' : '' }}>100</option>
                                <option value="all" {{ request('entri') == 'all' ? 'selected' : '' }}>Semua</option>
                            </select>
                        </li>&nbsp;
                        <li class="nav-item">
                            <input type="text" class="form-control" name="search" placeholder="search..." value="{{ request('search') }}">
                        </li>&nbsp;
                        <li class="nav-item">
                            <button type="submit" class="btn btn-success w-100"><i class="ri-search-eye-line"></i></button>
                        </li>&nbsp;
                        <li class="nav-item">
                            <input type="hidden" name="reset_filter" id="reset_filter" value="0">
                            <button type="submit" class="btn btn-danger w-100" onclick="resetFilter()" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Filter"><i class="ri-filter-off-line"></i></button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title"></h5>
                </div>
            </div>
            @if (!empty($searchMessage))
            <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
                {{ $searchMessage }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col" style="width: 50px">No</th>
                            <th scope="col">Kode Produk</th>
                            <th scope="col">Gambar Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ices as $key => $data)
                        <tr>
                            <th scope="row">{{ $loop->iteration }} <input class="form-check-input" type="checkbox" name="selected_ices[]" value="{{ $data->id }}"></th>
                            <td>{{ $data->kode_produk ?? '-' }}</td>
                            <td class="text-center">
                                <img width="30px" height="30px" src="{{ asset('gambar_produk/' . $data->gambar_produk ?? '') }}" alt="Preview Gambar">
                            </td>

                            <td>{{ $data->nama_produk ?? '-' }}</td>
                            <td>{{ number_format($data->harga_jual, 0, ',', '.') ?? '-' }}</td>
                            <td>{{ $data->stok ?? '-' }}</td>
                            <td class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                <form id="delete-form-{{ $data->id }}" action="{{ route('destroy.produk', $data->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteConfirmation('{{ $data->id }}', '{{ $data->nama_produk }}')" class="btn btn-danger delete-row"><i class="ri-delete-bin-6-fill"></i></button>&nbsp;
                                </form>
                                <form action="#">
                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#Mdl_edit_es-{{ $data->id }}"><i class="ri-edit-2-fill"></i></button>&nbsp;
                                </form>
                                <form action="#">
                                    <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#Mdl_detail_es-{{ $data->id }}"><i class="ri-eye-fill text-white"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row align-items-center mt-2 mb-2">
                <div class="col d-flex">
                    <button class="btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#Mdl_tambah_es">
                        <i class="ri-add-circle-line"></i>
                    </button>
                    <form action="{{ route('ice.hapus_terpilih') }}" method="POST" enctype="multipart/form-data" id="delete-selected-form">
                        @csrf
                        <button class="btn btn-danger" type="button" id="btn-hapus-terpilih">
                            <i class="ri-delete-bin-6-fill"></i> Hapus Terpilih
                        </button>
                    </form>
                </div>
                @if ($entries !== 'all')
                <div class="col-auto">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{ $ices->appends(['search' => $searchKeyword, 'entri' => $entries])->links() }}
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('eskrim.modal_add')
@include('eskrim.detail')
@include('eskrim.modal_edit')

<script>
    function resetFilter() {
        document.getElementById('reset_filter').value = '1';
    }

    function deleteConfirmation(id, namaProduk) {
        Swal.fire({
            title: 'Yakin hapus produk "' + namaProduk + '" ?',
            // text: 'Anda tidak dapat mengembalikan data yang dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            // Konfigurasi animasi
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika konfirmasi diiyakan
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    $(document).ready(function() {
        $("#btn-hapus-terpilih").click(function() {
            var selectedIds = [];
            // Iterasi melalui semua checkbox yang dipilih
            $("input[name='selected_ices[]']:checked").each(function() {
                // Push nilai checkbox yang dipilih ke dalam array selectedIds
                selectedIds.push($(this).val());
                // Tambahkan input tersembunyi untuk setiap ID yang dipilih
                $("#delete-selected-form").append('<input type="hidden" name="selected_ids[]" value="' + $(this).val() + '">');
            });

            // Sekarang setelah semua nilai checkbox yang dipilih ditambahkan ke dalam array selectedIds,
            // console.log(selectedIds); di sini akan mencetak nilai yang benar.
            console.log(selectedIds);

            if (selectedIds.length > 0) {
                if (confirm('Yakin ingin menghapus ' + selectedIds.length + ' produk?')) {
                    $("#delete-selected-form").submit();
                }
            } else {
                alert('Silakan pilih produk yang ingin dihapus.');
            }
        });
    });
</script>
@endsection
