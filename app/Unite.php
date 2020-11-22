<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
  protected $fillable = ['symboleUnite','nomUnite'];

  public function produits(){
    return $this -> belongsToMany('App\Produit')->withTimestamps();
  }
}
