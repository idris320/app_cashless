<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\transaksi;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::user();
        // $idwali = $user->id_pegawai;
        // $data = WaliSantri::find($idwali)->transaksi()->with('detail.barang', 'santri')->get();
        // return view('dashboardwali.transaksi', compact('data'));
    }

    public function showSantri($id)
    {
        $data = Santri::with(['transaksi.detail.barang'])->findOrFail($id);
        return view('dashboardwali.transaksi', compact('data'));
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
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
