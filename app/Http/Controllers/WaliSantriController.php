<?php

namespace App\Http\Controllers;

use App\Models\WaliSantri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class WaliSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WaliSantri::get();

        return view('walisantri.wsindex', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'id_wali' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required|unique:all_users,username',
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        try{
            $user = User::create([
            'id' => $request->id_user,
            'username' => $request->no_telp,
            'password' => Hash::make($request['password']),
            'role' => 'wali_santri'
        ]);

        WaliSantri::create([
            'id' => $request->id_wali,
            'iduser' => $user->id,
            'nama_wali' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email
        ]);

        return redirect(route('walisantri.index'))->with('success', 'Data Wali Santri Berhasil Ditambahkan');
        } catch (\Exception $e) {        
            return redirect()->back()->with('error', 'Gagal mengganti kartu. Silakan periksa data dan coba lagi.');
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(WaliSantri $waliSantri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WaliSantri $id)
    {
        //
        $data = WaliSantri::find($id);
        return view('walisantri.wsupdate', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WaliSantri $walisantri, $id)
    {
        $walisantri = WaliSantri::with('user')->findOrFail($id);
        $user    = $walisantri->user;

        $validator = Validator::make($request->all(), [
            'nama_wali' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            // Update data walisantri
            $walisantri->nama_wali   = $request->nama_wali;
            $walisantri->alamat = $request->alamat;                    
            if ($walisantri->no_telp !== $request->no_telp) {
                $walisantri->no_telp  = $request->no_telp;
                $user->username    = $request->no_telp;
            }
            $walisantri->email  = $request->email;

            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $walisantri->save();
            $user->save();

            DB::commit();

            return redirect()->route('walisantri.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaliSantri $waliSantri, $id)
    {
        DB::beginTransaction();

        try {
            $walisantri = WaliSantri::findOrFail($id);

            // Hapus user terkait
            if ($walisantri->user) {
                $walisantri->user->delete();
            }

            // Hapus walisantri
            $walisantri->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data walisantri dan user berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
