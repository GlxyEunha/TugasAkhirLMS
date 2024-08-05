@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Mata Pelajaran</h1>
        </div>

        <div class="section-body">

            @can('mapel.create')
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-word"></i> Upload Mata Pelajaran</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('mapel.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>MATA PELAJARAN</label>
                                <input type="text" name="mapel" value="{{ old('mapel') }}" placeholder="Masukkan Judul Document" class="form-control @error('mapel') is-invalid @enderror">
                                @error('mapel')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-upload"></i> UPLOAD</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                        </form>
                    </div>
                </div>
            @endcan

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-key"></i> Mata Pelajaran</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('mapel.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q" placeholder="cari berdasarkan mata pelajaran">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">MATA PELAJARAN</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($mapel as $no => $mapels)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($mapel->currentPage()-1) * $mapel->perPage() }}</th>
                                    <td>{{ $mapels->mapel }}</td>
                                    <td class="text-center">
                                        @can('mapel.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $mapels->id }}" title="Hapus Mapel">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $mapel->links("vendor.pagination.bootstrap-4") }}
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
                        url: "{{ route("mapel.index") }}/"+id,
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
