<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReglementCli extends Model
{
    protected $fillable = ['commande_id','dateReg','montanteVerse','numeroSupport','typeReg'];
}
