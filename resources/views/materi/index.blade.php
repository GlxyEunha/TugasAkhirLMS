@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Materi</h1>
        </div>

        <div class="section-body">

            @can('materis.create')
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-word"></i> Upload Materi</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('materis.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>TITLE</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Document" class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>DOCUMENT</label>
                                <input type="file" name="materi" class="form-control @error('materi') is-invalid @enderror">

                                @error('materi')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>CAPTION</label>
                                <input type="text" name="caption" value="{{ old('caption') }}" placeholder="Masukkan Caption document" class="form-control @error('caption') is-invalid @enderror">

                                @error('caption')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>MATA PELAJARAN</label>
                                <select name="mapel" class="form-control @error('mapel') is-invalid @enderror">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mapels as $m)
                                    <option value="{{ $m->mapel }}">{{ $m->mapel }}</option>
                                    @endforeach
                                    <!-- Tambahkan opsi-opsi mata pelajaran lainnya sesuai kebutuhan -->
                                </select>
                        
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

            {{-- @foreach($mapel as $m)
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-word"></i> {{ $m->mapel }}</h4>
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
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($mapel->materis as $no => $materi)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                    <td>
                                        <a href="{{ Storage::url('public/documents/'.$materi->link) }}" download> <i class="fas fa-file-download"></i> Download
                                    </td>
                                    <td>{{ $materi->title }}</td>
                                    <td>{{ $materi->caption }}</td>
                                    <td class="text-center">
                                        @can('materis.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $materi->id }}" title="Hapus Materi">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($mapel->materis->count() > 0)
                            <div style="text-align: center">
                                {{$mapel->materis->links("vendor.pagination.bootstrap-4")}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach --}}
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
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
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
                                    <td class="text-center">
                                        @can('materis.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $materi->id }}" title="Hapus Materi">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
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
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
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
                                    <td class="text-center">
                                        @can('materis.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $materi->id }}" title="Hapus Materi">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
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
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
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
                                    <td class="text-center">
                                        @can('materis.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $materi->id }}" title="Hapus Materi">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
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