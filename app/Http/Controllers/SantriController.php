<?php

namespace App\Http\Controllers;

use App\Models\santri;
use App\Models\Santri as ModelsSantri;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Santri::with('wali')->get();    
        $ws = WaliSantri::get();
        return view('santri.santri', compact('data','ws'));
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
        if($request->role == 'santri'){
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'role' => 'required',
                'nama' => 'required',
                'alamat' => 'required',                
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'wali_santri' => 'required'
            ]);

            if ($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
                // dd('Validasi gagal', $validator->errors());
            }

            $data = [
                'id' => $request->id,
                'id_wali' => $request->wali_santri,
                'nama_santri' => $request->nama,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => 'aktif'
            ];
            
            Santri::create($data);
            return redirect(route('santri.index'))->with('success', 'Data Santri Berhasil Ditambahkan');

            // dd($data);
            
        }elseif($request->role == 'wali'){
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
                'nama_wali' => $request->nama,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'email' => $request->email
            ];

            WaliSantri::create($data);
            return redirect(route('santri.index'))->with('success', 'Data Wali Santri Berhasil Ditambahkan');
        }
        return 'ada yang salah';
    }

    /**
     * Display the specified resource.
     */
    public function show(santri $santri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $id)
    {
        $data = Santri::with('wali')->find($id);        
        $walis = WaliSantri::all();
        // $data = Santri::find($id);
        return view('santri.santriupdate', compact('data', 'walis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, santri $santri, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'role' => 'required',
            'nama' => 'required',
            'alamat' => 'required',                
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'wali_santri' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
            // dd('Validasi gagal', $validator->errors());
        }

        $data = [            
            'id_wali' => $request->wali_santri,
            'nama_santri' => $request->nama,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
        ];

        Santri::whereId($id)->update($data);
        return redirect(route('santri.index'))->with('success','Data Berhasil Diubah');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(santri $santri, $id)
    {
        //
        $data = Santri::find($id);
        if($data){
            $data->delete();
            return redirect(route('santri.index'))->with('success', 'Data Santri Berhasil Dihapus');
        }else{
            return redirect(route('santri.index'))->with('error', 'Data gagal dihapus. ID tidak ditemukan.');
        }

    }
}
