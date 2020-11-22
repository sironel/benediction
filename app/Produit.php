<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['famille_produit_id','nomproduit','photo','description'];

    public function unites(){
      return $this -> belongsToMany('App\Unite', 'produit_unite','produit_id', 'unite_id')->withTimestamps();
    }
}
