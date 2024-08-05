@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Homework</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Edit Homework</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('homework.update', $homework->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>NAME</label>
                            <input type="text" name="name" value="{{ old('name', $homework->name) }}" class="form-control" >
                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>DESCRIPTION</label>
                            <textarea name="description" class="form-control">{{ old('description', $homework->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>DOCUMENT</label>
                            @if(isset($homework->file))
                                <div class="mb-2">
                                    <a href="{{ Storage::url('public/documents/' . $homework->file) }}" target="_blank">
                                        <i class="fas fa-file-download"></i> Lihat File Lama
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file" value="{{ old('file', $homework->file) }}" class="form-control @error('file') is-invalid @enderror">

                            @error('file')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>START</label>
                            <input type="datetime-local" name="start" value="<?php echo date('Y-m-d\TH:i:s', strtotime($homework->start)); ?>" class="form-control @error('start') is-invalid @enderror">

                            @error('start')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>END</label>
                            <input type="datetime-local" name="end" value="<?php echo date('Y-m-d\TH:i:s', strtotime($homework->end)); ?>" class="form-control @error('end') is-invalid @enderror">

                            @error('end')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>KELAS</label>
                            <select id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror">
                                <option value="">Pilih Kelas</option>
                                <option value="A" {{ old('kelas', $homework->kelas) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('kelas', $homework->kelas) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('kelas', $homework->kelas) == 'C' ? 'selected' : '' }}>C</option>
                                <!-- Tambahkan opsi-opsi kelas lainnya sesuai kebutuhan -->
                            </select>
                            
                            @error('kelas')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- @livewire('question-checklist', ['selectedExam' => $exam->id]) --}}


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