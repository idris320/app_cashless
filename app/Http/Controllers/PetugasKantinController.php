<?php

namespace App\Http\Controllers;

use App\Models\PetugasKantin;
use Illuminate\Http\Request;

class PetugasKantinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('petugaskantin');
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
    public function show(PetugasKantin $petugasKantin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetugasKantin $petugasKantin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetugasKantin $petugasKantin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetugasKantin $petugasKantin)
    {
        //
    }
}
