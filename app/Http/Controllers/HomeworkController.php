<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Homework;
use App\Models\HomeworkUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class HomeworkController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:homeworks.index|homeworks.create|homeworks.edit|homeworks.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
        if($currentUser->hasRole('admin')){
            $homework = Homework::latest()->when(request()->q, function($homework) {
                $homework = $homework->where('name', 'like', '%'. request()->q . '%');
            })->paginate(10);
        }elseif($currentUser->hasRole('student')){
            // $homework = Homework::whereHas('users', function (Builder $query) {
            //     $query->where('user_id', Auth()->id());
            // })->paginate(10);
            // $homework = Homework::latest()->when(request()->q, function($query) {
            //     $query->where('title', 'like', '%' . request()->q . '%');
            // })->paginate(10);
            $homework = Homework::select('homework.*', 'homework_user.nilai')
            ->leftJoin('homework_user', function($join) {
                $join->on('homework.id', '=', 'homework_user.homework_id')
                     ->where('homework_user.user_id', '=', Auth()->id());
            })
            // ->leftJoin('user', function($join) {
            //     $join->on('homework.id', '=', 'user.id')
            //          ->where('homework_user.user_id', '=', Auth()->id());
            // })
            ->leftJoin('users', 'users.kelas', '=', 'homework.kelas')
            ->where('users.kelas', '=', $currentUser->kelas)
            ->latest()
            ->when(request()->q, function($query) {
                $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);
        }elseif($currentUser->hasRole('teacher')){
            $homework = Homework::where('created_by', Auth()->id())->latest()->when(request()->q, function($homework) {
                $homework = $homework->where('created_by', Auth()->id())->where('name', 'like', '%'. request()->q . '%');
            })->paginate(10);
        }
        
        $user = new User();

        return view('homework.index', compact('homework','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('homework.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'description'   => 'required',
            'file'          => 'required|file',
            'start'         => 'required',
            'end'           => 'required',
            'kelas'         => 'required'
        ]);

        // Store the file and get its hashed name
        $file = $request->file('file');
        $filePath = $file->storeAs('public/documents', $file->hashName());

        // Create a new homework entry
        $homework = Homework::create([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'file'          => $file->hashName(), // Save the file name in the database
            'status'        => 'Belum Mengumpulkan',
            'start'         => $request->input('start'),
            'end'           => $request->input('end'),
            'kelas'         => $request->input('kelas'),
            'created_by'    => auth()->id()
        ]);

        if ($homework) {
            // Redirect with success message
            return redirect()->route('homework.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            // Redirect with error message
            return redirect()->route('homework.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get homework by ID
        $homework = Homework::findOrFail($id);

        // Get all files related to this homework ID with pagination
        $files = HomeworkUser::with('user') // Mengambil relasi 'user'
                            ->where('homework_id', $id)
                            ->paginate(10); // Ubah angka 10 sesuai dengan jumlah item per halaman yang diinginkan

        // Pass the files and homework data to the view
        return view('homework.show', compact('homework', 'files'));
    }

    public function tumpuk($id)
    {
        //get post by ID
        $homework = Homework::findOrFail($id);

        //render view with post
        return view('homework.tumpuk', compact('homework'));
    }

    public function submit(Request $request, $id)
    {
        $this->validate($request, [
            'homework' => 'required',
        ]);
    
        // Ambil data homework berdasarkan $id yang diterima dari URL
        $homework = Homework::findOrFail($id);
    
        $uploadedFile = $request->file('homework');
        $fileName = $uploadedFile->hashName();
    
        // Hapus file lama jika ada
        if ($homework->file) {
            Storage::delete('public/documents/' . $homework->file);
        }
    
        // Upload file baru
        $uploadedFile->storeAs('public/documents', $fileName);
    
        // Update Homework model
        $homework->update([
            'file' => $fileName
        ]);
    
        // Associate homework with user
        $user = Auth::user(); // Assuming you have authentication set up
        $homeworkUser = HomeworkUser::where('homework_id', $homework->id)
                                      ->where('user_id', $user->id)
                                      ->first();
    
        // Jika belum ada record, buat yang baru
        if (!$homeworkUser) {
            $homeworkUser = new HomeworkUser();
            $homeworkUser->homework_id = $homework->id;
            $homeworkUser->user_id = $user->id;
        }
    
        // Update file
        $homeworkUser->file = $fileName; // File name stored in database
        $homeworkUser->save();
    
        // Redirect with success message
        return redirect()->route('homework.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get post by ID
        $homework = Homework::findOrFail($id);

        //render view with post
        return view('homework.edit', compact('homework'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $homework)
    {
        $this->validate($request, [
            'name'          => 'required',
            'description'   => 'required',
            'file'          => 'nullable|file', // Make file validation nullable
            'start'         => 'required',
            'end'           => 'required',
            'kelas'         => 'required',
        ]);

        // Check if a file was uploaded
        if ($request->hasFile('file')) {
            // Store the new file and get its path
            $file = $request->file('file');
            $filePath = $file->storeAs('public/documents', $file->hashName());

            // Update with the new file name
            $homework->file = $file->hashName();
        }

        // Update other fields
        $homework->update([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'status'        => 'Belum Mengumpulkan',
            'start'         => $request->input('start'),
            'end'           => $request->input('end'),
            'kelas'         => $request->input('kelas'),
            'created_by'    => auth()->id()
        ]);

        // Save the changes
        $homework->save();

        if ($homework) {
            // Redirect with success message
            return redirect()->route('homework.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            // Redirect with error message
            return redirect()->route('homework.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homework = Homework::findOrFail($id);
        $homework->delete();

        if($homework){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function isinilai($id)
    {
        //get post by ID
        $files = HomeworkUser::findOrFail($id);

        //render view with post
        return view('homework.nilai', compact('files'));
    }

    public function nilai(Request $request, $id)
    {
        $this->validate($request, [
            'nilai' => 'required|numeric|min:0|max:100', // Menambahkan validasi bahwa nilai harus berupa angka antara 0 dan 100
        ]);
    
        // Cari data tugas berdasarkan $id yang diterima dari URL
        $homework = HomeworkUser::findOrFail($id);
    
        // Perbarui nilai tugas
        $homework->nilai = $request->nilai;
        $homework->save();

        // Redirect with success message
        return redirect()->route('homework.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
