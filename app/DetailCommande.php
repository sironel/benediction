<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailCommande extends Model
{
    protected $fillable = ['commande_id','prix_vente_id','prix_vente_id','quantiteProdCom','livrer'];
}
