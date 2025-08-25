<?php

namespace App\Http\Controllers;

use App\Models\kartu;
use App\Models\Santri;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KartuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kartu::with('santri')->get();
        $stk = Santri::whereDoesntHave('kartu')->get();
        return view('kartu.kartu', compact('data', 'stk'));
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
                'id_kartu' => 'required',
                'id_santri' => 'required',
                'no_kartu' => 'required',                             
                'tanggal_aktivasi' => 'required',               
                'password' => 'required|min:6',                
            ]);     

            if ($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
                // dd('Validasi gagal', $validator->errors());
            }

            $cekKartu = Kartu::where('no_kartu', $request->no_kartu)->first();
            if($cekKartu){
                return back()->with('error', 'Nomor kartu' .$request->no_kartu. 'sudah terdaftar');
            }

            $data = [
                'id' => $request->id_kartu,
                'id_santri' => $request->id_santri,
                'no_kartu' => $request->no_kartu,
                'pin' => Hash::make($request['pin']),
                'saldo' => 0,
                'tanggal_aktivasi' => $request->tanggal_aktivasi,
                'tanggal_perubahan' => '-',
                'status' => 'aktif',
                'keterangan' => 'Kartu Baru'
            ];

            Kartu::create($data);
            return redirect(route('kartu.index'))->with('success', 'Data kartu berhasil di daftarkan atas nama'. $request->nama_santri);
    }

    /**
     * Display the specified resource.
     */
    public function show(kartu $kartu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kartu $kartu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kartu $kartu)
    {
        //
    }

    public function updatePassword(Request $request, kartu $kartu, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'keterangan' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id' => $id,
            'password' => Hash::make($request['password']),
            'keterangan' => $request->keterangan
        ];

        dd($data);

        Kartu::where($id)->update($data);
        return redirect(route('kartu.index'))->with('success', 'password berhasil di Ubah');
    }

    public function updateStatus(Request $request)
    {
        $kartu = Kartu::findOrFail($request->id);
        $kartu->status = $request->status;
        $kartu->save();    

        return response()->json(['success' => true]);
    }

    public function topup(Request $request, kartu $kartu)
    {
        $validator = Validator::make($request->all(),[
            'nominal' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
        DB::transaction(function () use ($request) {
            // Ambil kartu santri
            $kartu = Kartu::where('id', $request->id_kartu)->firstOrFail();

            // Simpan saldo sebelum top-up
            $beforeSaldo = $kartu->saldo;

            // Update saldo
            $kartu->saldo += $request->nominal;
            
            $kartu->save();

            // // Catat histori transaksi
            Transaksi::create([
                'id' => random_int(100000, 999999),
                'id_santri'     => $request->id_santri,
                'id_pegawai'    => $request->id_pegawai,
                'jenis'         => 'topup',
                'total'       => $request->nominal,
                'saldo_awal'  => $beforeSaldo,
                'saldo_akhir'   => $kartu->saldo,  
                'tanggal_transaksi' =>now()->format('Y-m-d')
            ]);

        });


        return redirect()->back()->with('success', 'Top-up berhasil dilakukan sebesar Rp.'. number_format($request->nominal, 0, ',', '.'));
    } catch (\Exception $e) {
        // Logging error untuk debugging       

        return redirect()->back()->with('error', 'Terjadi kesalahan saat top-up. Silakan coba lagi.');
    }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kartu $kartu)
    {
        //
    }
}
