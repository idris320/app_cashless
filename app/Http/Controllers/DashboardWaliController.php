<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use App\Models\DashboardWali;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();
        $idwali = $user->id_pegawai;
        $data = Santri::where('id_wali', $idwali, 'kartu')->get();
        return view('dashboardwali.dashboardwali', compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DashboardWali $dashboardWali)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DashboardWali $dashboardWali, $id)
    {
        $data = WaliSantri::where('id', $id)->get();       
        return view('dashboardwali.editprofile', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DashboardWali $dashboardWali, $id)
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

            return redirect()->route('dashboardwali')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DashboardWali $dashboardWali)
    {
        //
    }
}
