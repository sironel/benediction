<?php

namespace App\Http\Controllers;

use App\Achat;
use Illuminate\Http\Request;
use App\Fournisseur;
use DB;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $four = Fournisseur::orderBy('nomf','asc')->get();
        $produ = DB::table('produit_unite')->join('produits','produit_unite.produit_id','produits.id')
        ->join('unites', 'produit_unite.unite_id', 'unites.id')
        ->join('famille_produits', 'produits.famille_produit_id', 'famille_produits.id')
        ->select('nomproduit','nomUnite','produit_unite.id','nomfamille')
        ->orderBy('nomproduit','asc')
        ->get();

        $achats = DB::table('Achats')->join('produit_unite','Achats.produit_unite_id','produit_unite.id')
        ->join('produits','produit_unite.produit_id','produits.id')
        ->join('unites', 'produit_unite.unite_id', 'unites.id')
        ->join('famille_produits', 'produits.famille_produit_id', 'famille_produits.id')
        ->select('Achats.id','nomproduit','nomUnite','quantite','prix','frais','livre','date_achat','nomfamille')
        ->orderBy('nomproduit','asc')
        ->get();

        return view('admin.achat' , compact(['four','produ','achats']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $achat = New Achat;
        $achat->achat_id=$request->get('fournisseur_id');
        $achat->produit_id=$request->get('produit_id');
         $achat->prix=$request->get('prix');
        $achat->frais=$request->get('frais');
        $achat->livre=$request->get('livre');
        $achat->profit=$request->get('profit');
        $achat->quantite=$request->get('quantite');
        $achat->save();
        return Response::json($achat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function show(Achat $achat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function edit(Achat $achat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achat $achat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $achat)
    {
        //
    }
}
