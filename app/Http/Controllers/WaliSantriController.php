<?php

namespace App\Http\Controllers;

use App\Models\WaliSantri;
use Illuminate\Http\Request;
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
            'no_telp' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id' => $request->id_wali,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email
        ];

        WaliSantri::create($data);
        return redirect(route('walisantri.index'))->with('success', 'Data Wali Santri Berhasil Ditambahkan');
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
    public function update(Request $request, WaliSantri $waliSantri, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_wali' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email
        ];

        WaliSantri::whereId($id)->update($data);
        return redirect(route('walisantri.index'))->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaliSantri $waliSantri, $id)
    {
        $wali = WaliSantri::with('santri')->find($id);

        if (!$wali) {
            return redirect()->route('walisantri.index')->with('error', 'Data tidak ditemukan.');
        }
    
        if ($wali->santri->count() > 0) {
            return redirect()->route('walisantri.index')
                ->with('error', 'Data tidak bisa dihapus karena masih digunakan oleh data santri.');
        }
    
        $wali->delete();
        return redirect()->route('walisantri.index')->with('success', 'Data berhasil dihapus.');
    }
}
