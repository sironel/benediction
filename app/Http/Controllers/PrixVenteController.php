<?php

namespace App\Http\Controllers;
use DB;
use App\Prixvente;
use Illuminate\Http\Request;

class PrixVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

public function prix_produit()
    {
        $lprix= DB::table('prixventes')
        ->join('produit_unite' , 'prixventes.produit_unite_id' ,'produit_unite.id')
        ->join('produits' , 'produit_unite.produit_id' ,'produits.id')
        ->join('unites' , 'produit_unite.unite_id' ,'unites.id')
        ->join('famille_produits' , 'produits.famille_produit_id' ,'famille_produits.id')
        ->select('produits.nomproduit','unites.symboleUnite','montant', 'nomfamille')
        ->orderBy('produits.nomproduit', 'ASC')->get();
        return view('prix')->with('lprix', $lprix);
    }

public function prix_to_Update()
    {
        $lprix= DB::table('prixventes')
        ->join('produit_unite' , 'prixventes.produit_unite_id' ,'produit_unite.id')
        ->join('produits' , 'produit_unite.produit_id' ,'produits.id')
        ->join('unites' , 'produit_unite.unite_id' ,'unites.id')
        ->join('famille_produits' , 'produits.famille_produit_id' ,'famille_produits.id')
        ->select('prixventes.id','produits.nomproduit','unites.symboleUnite','montant', 'nomfamille')
        ->orderBy('produits.nomproduit', 'ASC')->get();
        return view('Admin.prix_update')->with('lprix', $lprix);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrixVente  $prixVente
     * @return \Illuminate\Http\Response
     */
    public function show(PrixVente $prixVente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrixVente  $prixVente
     * @return \Illuminate\Http\Response
     */
    public function edit(PrixVente $prixVente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrixVente  $prixVente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrixVente $prixVente)
    {
        //
    }


    public function updatePrix(Request $request)
    {

        Prixvente::find($request->pk)->update([$request->name => $request->value]);

        return response()->json(['success'=>'done']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PrixVente  $prixVente
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrixVente $prixVente)
    {
        //
    }
}
