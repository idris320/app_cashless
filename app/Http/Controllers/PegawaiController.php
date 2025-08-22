<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai::get();
        return view('pegawai.pegawai', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {        
        $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'no_telp' => 'required',
        'email' => 'required',
        'alamat' => 'required',
        'posisi' => 'required',
        'password' => 'required|min:6',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if($request->posisi === 'admin'){
            $user = User::create([
                'id' => $request->idUser,
                'username' => $request->no_telp,
                'password' => Hash::make($request['password']),
                'role' => 'admin'
            ]);
    
    
            Pegawai::create([
                'id' => $request->id,
                'iduser' => $user->id,
                'nama_pegawai' => $request->nama,
                'alamat' => $request->alamat,        
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'posisi' => $request->posisi
            ]);
            return redirect(route('pegawai.index'))->with('success', 'Data Berhasil Ditambahkan');
        }else{
            Pegawai::create([
                'id' => $request->id,
                'iduser' => 0,
                'nama_pegawai' => $request->nama,
                'alamat' => $request->alamat,        
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'posisi' => $request->posisi
            ]);
            return redirect(route('pegawai.index'))->with('success', 'Data Berhasil Ditambahkan');
        }


        
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $id)
    {
        $data = Pegawai::find($id);
        return view('pegawai.pegawaiupdate', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai, $id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        $user    = $pegawai->user;

        $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'no_telp' => 'required',
        'email' => 'required',
        'alamat' => 'required',
        'posisi' => 'required',       
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            // Update data pegawai
            $pegawai->nama_pegawai   = $request->nama;
            $pegawai->alamat = $request->alamat;                    
            if ($pegawai->no_telp !== $request->no_telp) {
                $pegawai->no_telp  = $request->no_telp;
                $user->username    = $request->no_telp;
            }
            $pegawai->email  = $request->email;

            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $pegawai->save();
            $user->save();

            DB::commit();

            return redirect()->route('pegawai.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai, $id)
    {
        DB::beginTransaction();

        try {
            $pegawai = Pegawai::findOrFail($id);

            // Hapus user terkait
            if ($pegawai->user) {
                $pegawai->user->delete();
            }

            // Hapus pegawai
            $pegawai->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data pegawai dan user berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

    }
}
