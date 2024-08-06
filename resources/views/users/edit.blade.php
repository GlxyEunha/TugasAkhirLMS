@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-unlock"></i> Edit User</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>NAMA USER</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="Masukkan Email" class="form-control @error('email') is-invalid @enderror">

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
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        placeholder="Masukkan Password"
                                        class="form-control @error('password') is-invalid @enderror">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                        placeholder="Masukkan Konfirmasi Password" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="font-weight-bold">ROLE</label>
                           
                            @foreach ($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="role[]" value="{{ $role->name }}"
                                        id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="check-{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div> --}}

                        <div class="form-group">
                            <label>ROLE</label>
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->roles->first()->name) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="teacher" {{ old('role', $user->roles->first()->name) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="kurikulum" {{ old('role', $user->roles->first()->name) == 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                                <option value="student" {{ old('role', $user->roles->first()->name) == 'student' ? 'selected' : '' }}>Student</option>
                                <!-- Tambahkan opsi-opsi role lainnya sesuai kebutuhan -->
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
                                <option value="A" {{ old('kelas', $user->kelas) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('kelas', $user->kelas) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('kelas', $user->kelas) == 'C' ? 'selected' : '' }}>C</option>
                                <!-- Tambahkan opsi-opsi kelas lainnya sesuai kebutuhan -->
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
                                    <option value="{{ $m->mapel }}" {{ (old('mapel', $user->mapel) == $m->mapel) ? 'selected' : '' }}>
                                        {{ $m->mapel }}
                                    </option>
                                @endforeach
                                <!-- Tambahkan opsi-opsi mata pelajaran lainnya sesuai kebutuhan -->
                            </select>
                    
                            @error('mapel')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PERIODE</label>
                            <input type="text" name="periode" value="{{ old('periode', \Carbon\Carbon::parse($user->created_at)->format('Y')) }}"
                                   class="form-control @error('periode') is-invalid @enderror" disabled>
                        
                            @error('periode')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop