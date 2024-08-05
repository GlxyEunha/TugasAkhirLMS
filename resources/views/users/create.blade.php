@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah User</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-unlock"></i> Tambah User</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>NAMA USER</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                                class="form-control @error('email') is-invalid @enderror">

                            @error('email')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" value="{{ old('password') }}" placeholder="Masukkan Password"
                                        class="form-control @error('password') is-invalid @enderror">
        
                                    @error('password')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Masukkan Konfirmasi Password"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>ROLE</label>
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="kurikulum">Kurikulum</option>
                                <option value="student">Student</option>
                                <!-- Tambahkan opsi-opsi mata pelajaran lainnya sesuai kebutuhan -->
                            </select>
                            
                            @error('role')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>KELAS</label>
                            <select id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                <option value="">Pilih Kelas</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <!-- Tambahkan opsi-opsi mata pelajaran lainnya sesuai kebutuhan -->
                            </select>
                            
                            @error('kelas')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>MATA PELAJARAN</label>
                            <select name="mapel" class="form-control @error('mapel') is-invalid @enderror">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($mapel as $m)
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
                        
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@stop