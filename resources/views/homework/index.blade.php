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
                    <form action="{{ route('homework.index') }}" method="GET" enctype="multipart/form-data">
                        @hasanyrole('teacher|admin')
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('homeworks.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('homework.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama homework">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endhasanyrole
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">DOCUMENT</th>
                                @hasrole('student')
                                <th scope="col">NILAI</th>
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
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$homeworks->file) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    @hasrole('student')
                                    <td>
                                        @if ($homeworks->nilai == 0)
                                            <span>Belum Dinilai</span>
                                        @else
                                            {{ $homeworks->nilai }}
                                        @endif
                                    </td>
                                    @endhasrole
                                    <td>{{ TanggalID($homeworks->start) }}</td>
                                    <td>{{ TanggalID($homeworks->end) }}</td>
                                    <td class="text-center">
                                        @hasrole('teacher')
                                        <a href="{{ route('homework.show', $homeworks->id) }}" class="btn btn-sm btn-info" title="Lihat Tugas Siswa">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endhasrole
                                        @hasrole('student')
                                        {{-- <a href="{{ route('homework.tumpuk', $homeworks->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-paper-plane"></i>
                                        </a> --}}
                                        @if (now() > $homeworks->start && now() < $homeworks->end)
                                            <a id="homeworkButton" href="{{ route('homework.tumpuk', $homeworks->id) }}" class="btn btn-sm btn-info" title="Kirim Tugas"><i class="fa fa-paper-plane"></i></a>
                                        @elseif (now() < $homeworks->start)
                                            <a id="homeworkButton" onclick="disable()" class="btn btn-sm btn-info" title="Kirim Tugas"><i class="fa fa-paper-plane"></i></a>
                                        @elseif(now() > $homeworks->end)
                                            <a id="homeworkButton" onclick="disable()" class="btn btn-sm btn-info" title="Kirim Tugas"><i class="fa fa-paper-plane"></i></a>
                                        @endif
                                        @endhasrole


                                    
                                        @can('homeworks.edit')
                                            <a href="{{ route('homework.edit', $homeworks->id) }}" class="btn btn-sm btn-primary" title="Edit Tugas">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('homeworks.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $homeworks->id }}" title="Hapus Tugas">
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
    function disable() {
        document.getElementById("homeworkButton").disabled = true;
    }
</script>
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