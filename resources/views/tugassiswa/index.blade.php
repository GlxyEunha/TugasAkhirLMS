@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Homework</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Homework</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">DESCRIPTION</th>
                                @hasrole('student')
                                <th scope="col">STATUS</th>
                                @endhasrole
                                <th scope="col">START</th>
                                <th scope="col">END</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($homework as $no => $homeworks)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($homework->currentPage()-1) * $homework->perPage() }}</th>
                                    <td>{{ $homeworks->name }}</td>
                                    <td>{{ $homeworks->description }}</td>
                                    @hasrole('student')
                                    <td>{{ $homeworks->status }}</td>
                                    @endhasrole
                                    <td>{{ TanggalID($homeworks->start) }}</td>
                                    <td>{{ TanggalID($homeworks->end) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('homework.show', $homeworks->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @can('homeworks.edit')
                                            <a href="{{ route('homework.edit', $homeworks->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('homeworks.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $homeworks->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$homework->links("vendor.pagination.bootstrap-4")}}
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
                        url: "{{ route("homework.index") }}/"+id,
                        data:   {
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