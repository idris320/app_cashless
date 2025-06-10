<?php

namespace App\Http\Controllers;

use App\Models\santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('santri');
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

        dd($request->all());
        // $data['id'] = $request->id;
        // $data['nama'] = $request->nama;
        // $data['alamat'] = $request->alamat;
        // $data['tempat_lahir'] = $request->tempatLahir;
        // $data['tanggal_lahir'] = $request->ttl;
        // $data['jenis_kelamin'] = $request->jk;
        // $data['status'] = 'aktif';

        // var_dump($data);
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
    public function edit(santri $santri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, santri $santri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(santri $santri)
    {
        //
    }
}
