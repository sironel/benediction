<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use Response;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = liste_produit_unite();
        return view('gestionstock', compact('produits'));
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
      $data=[
          'produit_unite_id'=>$request->get('produit_unite_id'),
          'quantite'=>$request->get('quantite')

          ];
     $stock=store_data('Stock',$data);
     return Response::json($stock);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */


     public function getStock(){
         return response()->json(Stock::all());
     }

    public function update(Request $request, $id)
    {
        $data = [
        'produit_unite_id'=> $request->get('produit_unite_id'),
        'quantite'=> $request->get('quantite')
      ];
        $stock = update_data('Stock', $data, $id);

          return Response::json($stock);
            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
      return Response::json(delete_data('Stock',$id));
    }
}
