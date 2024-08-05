@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Isi Nilai</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Isi Nilai</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('homework.nilai', $files->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>NILAI</label>
                            <input type="text" name="nilai" value="{{ old('nilai') }}" class="form-control" placeholder="Isi nilai antara 1-100">
                            @error('nilai')
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