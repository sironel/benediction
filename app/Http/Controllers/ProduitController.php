<?php

namespace App\Http\Controllers;
use DB;
use App\FamilleProduit;
use App\Unite;
use App\Produit;
use App\Prixvente;
use App\Produit_Unite;
use Response;
use Validator;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familles = FamilleProduit::orderBy('nomfamille')->get();
        $unites = Unite::orderBy('nomUnite')->get();
        $produits = Produit::orderBy('nomproduit')->get();
        $produitCount = $produits->count();
        return view('Articles.create',['familles'=>$familles,'unites'=>$unites,'produits'=>$produits,'produitCount'=>$produitCount]);
    }

    public function indexadm()
    {
        $familles = FamilleProduit::orderBy('nomfamille')->get();
        $unites = Unite::orderBy('nomUnite')->get();
        $produits = Produit::orderBy('nomproduit')->get();
        $produitCount = $produits->count();
        return view('Admin.create',['familles'=>$familles,'unites'=>$unites,'produits'=>$produits,'produitCount'=>$produitCount]);
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
        $produit = new Produit;
        $produit->famille_produit_id = $request->get('famille_produit_id');
        $produit->nomproduit = ucfirst($request->get('nomproduit'));
        $produit->description = $request->get('description');
        $produit->save();

        $produit_unite = new Produit_Unite;
        //$produit_unite->produit_id = $produit->id;
        $unite_id = $request->get('unite_id');
        $produit->unites()->attach($unite_id);

        $pu=DB::table('produit_unite')->where('produit_id',$produit->id)->get();
        foreach($pu as $p){
        $prix = new Prixvente;
        $prix->produit_unite_id =$p->id;
        $prix->montant =$request->get('montant');
        $prix->save();
        }
        
        return Response::json($produit);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $produit = Produit::find($id);
       return Response::json($produit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);
        $produit->famille_produit_id = $request->get('famille_produit_id');
        $produit->nomproduit = ucfirst($request->get('nomproduit'));
        $produit->description = $request->get('description');
        $produit->save();
        return Response::json($produit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {   $produit = Produit::find($id);
        $produit->delete();
        $nbproduit = Produit::all()->count();
        return Response::json(['id'=>$id, 'nbproduit'=>$nbproduit]);
    }


   public function upload(Request $request,$id)
   {
     $validation = Validator::make($request->all(), [
      'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);
     if($validation->passes())
     {
      $image = $request->file('file');
      $new_name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('photos'), $new_name);
       $produit = Produit::find($id);
       $produit->photo = '/photos/'.$new_name;
       $produit->save();
      return response()->json([
       'message'   => 'Upload réussi',
       'uploaded_image' => '<img src="/photos/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success',
       'photoPath' => '/photos/'.$new_name
      ]);
     }
     else
     {
      return response()->json([
       'message'   => $validation->errors()->all(),
       'uploaded_image' => '',
       'class_name'  => 'alert-danger'
      ]);
     }
    }

}
