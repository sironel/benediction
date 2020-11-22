<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prixvente extends Model
{
    protected $fillable = ['produit_unite_id', 'montant'];
}
