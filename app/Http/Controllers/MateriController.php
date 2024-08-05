<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:materis.index|materis.create|materis.delete|materisiswa.index|cekmateris.index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materisMatematika = Materi::where('mapel', 'Matematika')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
    
        $materisBahasa = Materi::where('mapel', 'Bahasa Indonesia')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $materisIPA = Materi::where('mapel', 'IPA')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
        $mapels = Mapel::with('materis')->get();
    
        return view('materi.index', compact('mapels', 'materisMatematika', 'materisBahasa', 'materisIPA'));
    }

    public function siswa()
    {
        $materisMatematika = Materi::where('mapel', 'Matematika')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
    
        $materisBahasa = Materi::where('mapel', 'Bahasa Indonesia')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $materisIPA = Materi::where('mapel', 'IPA')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
    
        return view('materisiswa.index', compact('materisMatematika', 'materisBahasa', 'materisIPA'));
    }

    public function cekmateri()
    {
        $materisMatematika = Materi::where('mapel', 'Matematika')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
    
        $materisBahasa = Materi::where('mapel', 'Bahasa Indonesia')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $materisIPA = Materi::where('mapel', 'IPA')->latest()->when(request()->q, function($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
    
        return view('cekmateri.index', compact('materisMatematika', 'materisBahasa', 'materisIPA'));
    }

    public function updateChecklist(Request $request)
    {
        $materi = Materi::findOrFail($request->id);
        $materi->completed = $request->completed;
        $materi->save();

        return response()->json(['success' => true]);
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
            'title'     => 'required',
            'materi'     => 'required|mimes:doc,docx,pdf',
            'caption'   => 'required',
            'mapel'   => 'required',
        ]);

        //upload document
        $materi = $request->file('materi');
        $materi->storeAs('public/documents', $materi->hashName());

        $materi = Materi::create([
            'title'     => $request->input('title'),
            'link'     => $materi->hashName(),
            'caption'   => $request->input('caption'),
            'mapel'   => $request->input('mapel')
        ]);

        // dd($materi);

        if($materi){
            //redirect dengan pesan sukses
            return redirect()->route('materis.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('materis.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $materi = Materi::findOrFail($id);
        $link= Storage::disk('local')->delete('public/documents/'.$materi->link);
        $materi->delete();

        if($materi){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
