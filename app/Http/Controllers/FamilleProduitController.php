<?php

namespace App\Http\Controllers;

use App\FamilleProduit;
use Illuminate\Http\Request;
// use Session;
use Response;
class FamilleProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
          $familleprod = new FamilleProduit;
          $familleprod->nomfamille =ucfirst($request->get('nomfamille'));
          $familleprod->save();
           // Session::flash('msg',  '<img src="images/valider.jpg" width="30" /> Famille de produit inserée avec succès');
    return Response::json($familleprod);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FamilleProduit  $familleProduit
     * @return \Illuminate\Http\Response
     */
    public function show(FamilleProduit $familleProduit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FamilleProduit  $familleProduit
     * @return \Illuminate\Http\Response
     */
    public function edit(FamilleProduit $familleProduit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FamilleProduit  $familleProduit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FamilleProduit $familleProduit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FamilleProduit  $familleProduit
     * @return \Illuminate\Http\Response
     */
    public function destroy(FamilleProduit $familleProduit)
    {
        //
    }
}
