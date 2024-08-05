<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use Illuminate\Support\Facades\Mail;

class MapelController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:mapel.index|mapel.create|mapel.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapel = Mapel::when(request()->q, function($query) {
            $query->where('mapel', 'like', '%' . request()->q . '%');
        })->paginate(5);

        // Return the view with the paginated mapel records
        return view('mapel.index', compact('mapel'));
    }

    public function examMapel(){
        // Ambil semua data dari tabel mapel
        $mapel = Mapel::all();

        // Kirim data ke view
        return view('exams.create', ['mapel' => $mapel]);
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
            'mapel'     => 'required',
        ]);

        $mapel = Mapel::create([
            'mapel'     => $request->input('mapel'),
        ]);

        // dd($mapel);

        if($mapel){
            //redirect dengan pesan sukses
            return redirect()->route('mapel.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('mapel.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        if($mapel){
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
