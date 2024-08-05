<?php

use App\Models\Exam;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //permissions
    Route::resource('permissions', PermissionController::class)->only([
        'index'
    ]);

    //roles
    Route::resource('roles', RoleController::class)->except([
        'show'
    ]);

    //users
    Route::resource('users', UserController::class)->except([
        'show'
    ]);

    //images
    Route::resource('images', ImageController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //videos
    Route::resource('videos', VideoController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //audios
    Route::resource('audios', AudioController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //documents
    Route::resource('documents', DocumentController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //materis
    Route::resource('materis', MateriController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //materis
    Route::resource('homework', HomeworkController::class);

    //mapel
    Route::resource('mapel', MapelController::class);

    // Route::delete('/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');

    //tumpuk tugas
    Route::get('/tumpuk/{id}', [HomeworkController::class, 'tumpuk'])->name('homework.tumpuk');
    Route::put('/submit/{id}', [HomeworkController::class, 'submit'])->name('homework.submit');

    //isi nilai
    Route::get('/isinilai/{id}', [HomeworkController::class, 'isinilai'])->name('homework.isinilai');
    Route::put('/nilai/{id}', [HomeworkController::class, 'nilai'])->name('homework.nilai');

    Route::get('/materisiswa', [MateriController::class, 'siswa'])->name('materis.siswa');

    Route::get('/cekmateri', [MateriController::class, 'cekmateri'])->name('cekmateris.index');
    Route::post('/update-checklist', [MateriController::class, 'updateChecklist'])->name('updateChecklist');

    //subjects
    Route::resource('subjects', SubjectController::class)->except([
        'show', 'create', 'edit', 'update'
    ]);

    //questions
    Route::resource('questions', QuestionController::class)->except([
        'show'
    ]);

    //exams
    
    Route::resource('exams', ExamController::class); 
    Route::get('/exams/result/{score}/{user_id}/{exam_id}', [ExamController::class, 'result'])->name('exams.result');
    Route::get('/exams/start/{id}', [ExamController::class, 'start'])->name('exams.start');
    Route::get('exams/student/{id}', [ExamController::class, 'student'])->name('exams.student');
    Route::put('exams/assign/{id}', [ExamController::class, 'assign'])->name('exams.assign');
    Route::get('/exams/review/{user_id}/{exam_id}', [ExamController::class, 'review'])->name('exams.review');
});
