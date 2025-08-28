<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Barang::get();
        return view('barang.barang', compact('data'));
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
        $vallidator = Validator::make($request->all(),[
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);
        if($vallidator->fails()){
            return redirect()->back()->withInput()->withErrors($vallidator);
        }

        Barang::create([
            'id' => $request->id_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga
        ]);
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, barang $barang, $id)
    {
        $vallidator = Validator::make($request->all(),[
            'id_barang' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);
        if($vallidator->fails()){
            return redirect()->back()->withInput()->withErrors($vallidator);
        }

        Barang::whereId($id)->update([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga
        ]);
        return redirect()->back()->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(barang $barang, $id)
    {
        $data = Barang::find($id);
        if($data){
            $data->delete();
            return redirect()->back()->with('success', 'Data berhasil di hapus');
        }else{
            return redirect()->back()->with('error', 'Data gagal di hapus');
        }        
    }
}
