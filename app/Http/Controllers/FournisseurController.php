<?php

namespace App\Http\Controllers;

use App\Fournisseur;
use Illuminate\Http\Request;
use Response;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $four = Fournisseur::orderBy('nomf','asc')->get();
        return view('Admin.fournisseur')->with('four' , $four);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fournisseur = New Fournisseur;
        $fournisseur->nomf=$request->get('nomf');
        $fournisseur->adresse=$request->get('adresse');
         $fournisseur->email=$request->get('email');
        $fournisseur->telephone=$request->get('telephone');
        $fournisseur->save();
        return Response::json($fournisseur);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $fournisseur = Fournisseur::find($id);
        $fournisseur->nomf=$request->get('nomf');
        $fournisseur->adresse=$request->get('adresse');
         $fournisseur->email=$request->get('email');
        $fournisseur->telephone=$request->get('telephone');
        $fournisseur->save();
        return Response::json($fournisseur);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Fournisseur::destroy($id);
        return Response::json($id);

    }
}
