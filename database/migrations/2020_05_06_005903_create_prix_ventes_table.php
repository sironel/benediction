<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrixVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prix_ventes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('produit_unite_id')->unsigned();
            $table->double('montant');
            $table->DateTime('dateprix');
            $table->foreign('produit_unite_id')->references('id')->on('produit_unites');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prix_ventes');
    }
}
