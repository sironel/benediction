<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['client_id','credit', 'delaiPaiment', 'commandeClose','regComplet','dateCommande'];
}
