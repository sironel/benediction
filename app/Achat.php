<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = ['fournisseur_id','produit_unite_id','prix','frais','profit','quantite','livre'];
}
