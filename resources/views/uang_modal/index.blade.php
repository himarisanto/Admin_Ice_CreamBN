@extends('layout.master')
@section('content')
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="row gx-4 d-flex justify-content-between">
            <div class="col-auto d-flex align-items-center">
                <a href="#" class="mr-2">
                    <i class="ri-money-dollar-circle-fill fs-3"></i>
                </a>&nbsp;
                <h5 class="mb-0 mt-0"><strong>Uang Kas</strong></h5>
            </div>
            <div class="col-auto d-flex align-items-center">
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                    <li class="nav-item">
                        <span class="display-6">{{ $formattedmasteruangs ?? '' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-auto d-flex align-items-center">
                        <h5 class="card-title">Seluruh Modal = {{ $formattedTotalModal }}</h5>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_uang">
                            <i class="ri-add-circle-fill"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 50px">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nominal uang</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($uangmodals as $key => $data)
                            <tr>
                                <th scope="row">{{ $uangmodals->firstItem() + $key }} <input class="form-check-input" type="checkbox" name="selected_uangmodals[]" value="{{ $data->id }}"></th>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_simpan)->format('d F Y') ?? '-' }}</td>
                                <td>Rp {{ number_format($data->nominal_uang, 0, ',', '.' ?? '-') }}</td>
                                <td>{{ $data->keterangan ?? '-' }}</td>
                                <td class="d-flex justify-content-center">
                                    <form id="delete-form-{{ $data->id }}" action="{{ route('destroy.uangmodal', $data->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('DELETE')
                                        @php
                                        $formattedNominal = "Rp " . number_format($data->nominal_uang, 0, ',', '.' ?? '-');
                                        @endphp
                                        <button type="button" onclick="deleteConfirmation('{{ $data->id }}', '{{ $formattedNominal }}')" class="btn btn-danger delete-row"><i class="ri-delete-bin-6-fill"></i></button>&nbsp;
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data uang modal</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center mt-2 mb-2">
                    <div class="col d-flex">
                        <form action="{{ route('hapus_terpilih.uangmodal') }}" method="POST" enctype="multipart/form-data" id="delete-selected-form">
                            @csrf
                            <button class="btn btn-danger" type="button" id="btn-hapus-terpilih">
                                <i class="ri-delete-bin-6-fill"></i> Hapus Terpilih
                            </button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                {{ $uangmodals->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('uang_modal.modal_add')
<script>
    function deleteConfirmation(id, nominalUang) {
        Swal.fire({
            title: 'Yakin hapus "' + nominalUang + '" dari modal uang ?',
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
            $("input[name='selected_uangmodals[]']:checked").each(function() {
                // Push nilai checkbox yang dipilih ke dalam array selectedIds
                selectedIds.push($(this).val());
                // Tambahkan input tersembunyi untuk setiap ID yang dipilih
                $("#delete-selected-form").append('<input type="hidden" name="selected_ids[]" value="' + $(this).val() + '">');
            });

            // Sekarang setelah semua nilai checkbox yang dipilih ditambahkan ke dalam array selectedIds,
            // console.log(selectedIds); di sini akan mencetak nilai yang benar.
            console.log(selectedIds);

            if (selectedIds.length > 0) {
                if (confirm('Yakin ingin menghapus ' + selectedIds.length + ' data uang modal?')) {
                    $("#delete-selected-form").submit();
                }
            } else {
                alert('Silakan pilih data yang ingin dihapus.');
            }
        });
    });
</script>
@endsection
