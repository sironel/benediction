<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable = ['nom','prenom','ville','adresse','telephone','sexe'];
}
