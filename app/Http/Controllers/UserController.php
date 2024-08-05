<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->when(request()->q, function($users) {
            $users = $users->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();
        $mapel = Mapel::all();
        return view('users.create', compact('roles', 'mapel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed',
            'role'      => 'required', // Pastikan role juga divalidasi
            'kelas'     => 'required_if:role,student|required_if:role,teacher', // Hanya diperlukan jika peran yang dipilih adalah student
            'mapel'     => 'required_if:role,teacher'
        ]);

        // Cek jika peran yang dipilih adalah selain student dan kelas tidak kosong
        if (!in_array($request->input('role'), ['teacher', 'student']) && $request->input('kelas')) {
            return back()->withInput()->with(['error' => 'Peran ini tidak diizinkan untuk memilih kelas!']);
        }

        // Cek jika peran yang dipilih adalah selain teacher dan mapel tidak kosong
        if ($request->input('role') !== 'teacher' && $request->input('mapel')) {
            return back()->withInput()->with(['error' => 'Peran ini tidak diizinkan untuk memilih mapel!']);
        }

        // Buat pengguna baru
        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'kelas' => in_array($request->input('role'), ['student', 'teacher']) ? $request->input('kelas') : null, // Atur kelas jika perannya student atau teacher
            'mapel' => $request->input('role') === 'teacher' ? $request->input('mapel') : null, // Atur mapel jika perannya teacher
        ]);

        // Assign peran
        $user->assignRole($request->input('role'));

        // Redirect dengan pesan sukses
        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('users.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::latest()->get();
        $mapel = Mapel::all();
        return view('users.edit', compact('user', 'roles', 'mapel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required',
            'kelas' => 'required_if:role,student|required_if:role,teacher', // Diperlukan jika peran yang dipilih adalah student atau teacher
            'mapel' => 'required_if:role,teacher', // Diperlukan jika peran yang dipilih adalah teacher
        ]);

        // Cek jika peran yang dipilih adalah selain student dan kelas tidak kosong
        if (!in_array($request->input('role'), ['teacher', 'student']) && $request->input('kelas')) {
            return back()->withInput()->with(['error' => 'Peran ini tidak diizinkan untuk memilih kelas!']);
        }

        // Cek jika peran yang dipilih adalah selain teacher dan mapel tidak kosong
        if ($request->input('role') !== 'teacher' && $request->input('mapel')) {
            return back()->withInput()->with(['error' => 'Peran ini tidak diizinkan untuk memilih mapel!']);
        }

        // Update pengguna
        $user = User::findOrFail($user->id);

        if ($request->input('password') == "") {
            $user->update([
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
                'kelas' => in_array($request->input('role'), ['student', 'teacher']) ? $request->input('kelas') : null, // Atur kelas jika perannya student atau teacher
                'mapel' => $request->input('role') === 'teacher' ? $request->input('mapel') : null, // Atur mapel jika perannya teacher
            ]);
        } else {
            $user->update([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'kelas' => in_array($request->input('role'), ['student', 'teacher']) ? $request->input('kelas') : null, // Atur kelas jika perannya student atau teacher
                'mapel' => $request->input('role') === 'teacher' ? $request->input('mapel') : null, // Atur mapel jika perannya teacher
            ]);
        }

        // Assign peran
        $user->syncRoles($request->input('role'));

        // Redirect dengan pesan sukses atau error
        return redirect()->route('users.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();


        if($user){
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
