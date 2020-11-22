<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailProforma extends Model
{
    protected $fillable = ['proforma_id','prix_vente_id','quantiteProd'];
}
