@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Exam</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Tambah Exam</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>NAME</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" >
                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>WAKTU PENGERJAAN</label>
                            <input type="number" name="time" value="{{ old('time') }}" class="form-control" >

                            @error('time')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>TOTAL QUESTION</label>
                            <input type="number" id="total_question" name="total_question" value="{{ old('total_question') }}" class="form-control" >

                            @error('total_question')
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

                        <div class="form-group">
                            <label>START (UJIAN DIMULAI)</label>
                            <input type="datetime-local" name="start" value="<?= date('Y-m-d', time()); ?>" class="form-control @error('start') is-invalid @enderror">

                            @error('start')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>END (UJIAN DITUTUP)</label>
                            <input type="datetime-local" name="end" value="<?= date('Y-m-d', time()); ?>" class="form-control @error('end') is-invalid @enderror">

                            @error('end')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label>KELAS</label>
                            <select name="kelas" class="form-control @error('kelas') is-invalid @enderror">
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
                        </div> --}}

                        <livewire:question-checklist />


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
