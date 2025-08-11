<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',                
            'posisi' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
            // dd('Validasi gagal', $validator->errors());
        }

        
        $data = [
            'id' => $request->id,
            'nama_pegawai' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'posisi' => $request->posisi
        ];
        

        
        Pegawai::create($data);
        return redirect(route('pegawai.index'))->with('success', 'Data Berhasil Ditambahkan');

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
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',                
            'posisi' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
            // dd('Validasi gagal', $validator->errors());
        }

        $data = [            
            'nama_pegawai' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'posisi' => $request->posisi
        ];

        Pegawai::whereId($id)->update($data);
        return redirect(route('pegawai.index'))->with('success','Data Berhasil Diubah');        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai, $id)
    {
        $data = Pegawai::find($id);
        if($data){
            $data->delete();
            return redirect(route('pegawai.index'))->with('success', 'Data Berhasil Dihapus');
        }else{
            return redirect(route('pegawai.index'))->with('error', 'Data Gagal Dihapus');
        }

    }
}
