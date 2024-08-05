@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Materi</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-word"></i> Matematika</h4>
                </div>

                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">DOCUMENT</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">CAPTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($materisMatematika as $no => $materi)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($materisMatematika->currentPage()-1) * $materisMatematika->perPage() }}</th>
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$materi->link) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    <td>{{ $materi->title }}</td>
                                    <td>{{ $materi->caption }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$materisMatematika->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-word"></i> Bahasa Indonesia</h4>
                </div>

                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">DOCUMENT</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">CAPTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($materisBahasa as $no => $materi)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($materisBahasa->currentPage()-1) * $materisBahasa->perPage() }}</th>
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$materi->link) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    <td>{{ $materi->title }}</td>
                                    <td>{{ $materi->caption }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$materisBahasa->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-word"></i> IPA</h4>
                </div>

                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">DOCUMENT</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">CAPTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($materisIPA as $no => $materi)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($materisIPA->currentPage()-1) * $materisIPA->perPage() }}</th>
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$materi->link) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    <td>{{ $materi->title }}</td>
                                    <td>{{ $materi->caption }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$materisIPA->links("vendor.pagination.bootstrap-4")}}
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