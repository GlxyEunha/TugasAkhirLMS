@extends('layouts.app')

@section('content')
<style>
    .btn[disabled] {
    pointer-events: none;
    opacity: 1;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Homework</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-word"></i> Dokumen Tugas Siswa</h4>
                </div>

                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">DOCUMENT</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">NILAI</th>
                                <th scope="col">AKSI</th>
                                {{-- <th scope="col">TITLE</th>
                                <th scope="col">CAPTION</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($files as $no => $file)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($files->currentPage()-1) * $files->perPage() }}</th>
                                    <td>{{ $file->user->name }}</td>
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$file->file) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    <td>
                                        @if ($file->nilai == 0)
                                            <a href="#" class="btn btn-sm btn-danger" disabled>
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-success" disabled>
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $file->nilai }}</td>
                                    <td>
                                        <a href="{{ route('homework.isinilai', $file->id) }}" class="btn btn-sm btn-primary" title="Beri Nilai">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    {{-- <td>{{ $materi->title }}</td>
                                    <td>{{ $materi->caption }}</td> --}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$files->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {


                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route("materis.index") }}/"+id,
                        data:     {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
</script>
@stop