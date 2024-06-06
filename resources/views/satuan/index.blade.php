@extends('layout.master')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title"></h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col" style="width: 50px">No</th>
                            <th scope="col">Nama Satuan</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($satuans as $key => $data)
                        <tr>
                            <th scope="row">{{ $satuans->firstItem() + $key }} <input class="form-check-input" type="checkbox" name="selected_satuans[]" value="{{ $data->id }}"></th>
                            <td>{{ $data->nama_satuan ?? '-' }}</td>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                            <td class="d-flex justify-content-center">
                                <form id="delete-form-{{ $data->id }}" action="{{route('destroy.satuan', $data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteConfirmation('{{ $data->id }}', '{{ $data->nama_satuan }}')" class="btn btn-danger delete-row"><i class="ri-delete-bin-6-fill"></i></button>&nbsp;
                                </form>
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#Mdl_edit_satuan-{{ $data->id }}"><i class="ri-edit-2-fill"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data satuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row align-items-center mt-2 mb-2">
                <div class="col d-flex">
                    <button class="btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#Mdl_satuan">
                        <i class="ri-add-circle-line"></i>
                    </button>
                    <form action="{{route('satuan.hapus_terpilih')}}" method="POST" enctype="multipart/form-data" id="delete-selected-form">
                        @csrf
                        <button class="btn btn-danger" type="button" id="btn-hapus-terpilih">
                            <i class="ri-delete-bin-6-fill"></i> Hapus Terpilih
                        </button>
                    </form>

                </div>
                <div class="col-auto">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{ $satuans->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@include('satuan.modal_add')
@include('satuan.modal_edit')

<script>
    function deleteConfirmation(id, namaSatuan) {
        Swal.fire({
            title: 'Yakin hapus barang "' + namaSatuan + '" ?',
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
            $("input[name='selected_satuans[]']:checked").each(function() {
                // Push nilai checkbox yang dipilih ke dalam array selectedIds
                selectedIds.push($(this).val());
                // Tambahkan input tersembunyi untuk setiap ID yang dipilih
                $("#delete-selected-form").append('<input type="hidden" name="selected_ids[]" value="' + $(this).val() + '">');
            });

            // Sekarang setelah semua nilai checkbox yang dipilih ditambahkan ke dalam array selectedIds,
            // console.log(selectedIds); di sini akan mencetak nilai yang benar.
            console.log(selectedIds);

            if (selectedIds.length > 0) {
                if (confirm('Yakin ingin menghapus ' + selectedIds.length + ' satuan?')) {
                    $("#delete-selected-form").submit();
                }
            } else {
                alert('Silakan pilih produk yang ingin dihapus.');
            }
        });
    });
</script>

@endsection