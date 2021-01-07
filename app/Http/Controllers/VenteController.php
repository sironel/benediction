<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index(){
    	return view('admin.vente',['produits'=>consult_produits(),'clients'=>\App\Client::all()]);
    }

    
}
