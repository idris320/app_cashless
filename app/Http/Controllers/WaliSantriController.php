<?php

namespace App\Http\Controllers;

use App\Models\WaliSantri;
use Illuminate\Http\Request;

class WaliSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('walisantri');
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
        dd($request->all());
    //     $data = [
    //         'nama' => $request->nama(),
    //         'alamat' => $request->alamat()
    //     ];

    //     var_dump($data);
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
    public function edit(WaliSantri $waliSantri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WaliSantri $waliSantri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaliSantri $waliSantri)
    {
        //
    }
}
