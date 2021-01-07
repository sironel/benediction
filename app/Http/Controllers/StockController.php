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
     $qte_dispo = qte_produit_dispo($data['produit_unite_id']);
      array_push($stock,'nomp',$qte_dispo->nomproduit);
      array_push($stock,'nomu',$qte_dispo->nomunite);
      array_push($stock,'qte',$qte_dispo->Qte);
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
            $pu_id=Stock::where('id', $id)->pluck('produit_unite_id')[0];
            $stock = delete_data('Stock',$id);
            if(count(Stock::where('produit_unite_id', $pu_id)->get()) > 0){
                 $qte_dispo = qte_produit_dispo($pu_id);
                  array_push($stock,'nomp',$qte_dispo->nomproduit);
                  array_push($stock,'nomu',$qte_dispo->nomunite);
                  array_push($stock,'qte',$qte_dispo->Qte);
            }
            else{
                $np_up= get_nomp_unitep($pu_id);
                 array_push($stock,'nomp',$np_up->nomproduit);
                 array_push($stock,'nomu', $np_up->nomunite);
                  array_push($stock,'qte',0);
            }
      return Response::json($stock);
    }
}
