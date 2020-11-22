<?php

namespace App\Http\Controllers;
use Response;
use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
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
        $client = new Client;
        $client->nom=$request->nom;
        $client->prenom=$request->get('prenom'); 
        $client->ville=$request->get('ville');
        $client->adresse=$request->get('adresse');
        $client->telephone=$request->get('telephone');
        $client->sexe=$request->get('sexe');
        $client->save();
                 
        // $data=[
        //     'nom'=>$request->get('nom'),
        //     'prenom'=>$request->get('prenom'), 
        //     'ville'=>$request->get('ville'),
        //     'adresse'=>$request->get('adresse'),
        //     'telephone'=>$request->get('telephone'),
        //     'sexe'=>$request->get('sexe')
        // ];          
        
            // $cli=store_data('Client',$data);
            // $client=$cli['data'];
            return Response::json($client); 
         
    }

    public function getclient(){
        return response()->json(Client::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::findOrFail($id)->delete();
        return response()->json($id);
    }
}
