<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitUnitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_unites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('produit_id')->unsigned();
            $table->bigInteger('unite_id')->unsigned();
            $table->bigInteger('stockCritique');
            $table->bigInteger('stockBas');
            $table->foreign('produit_id')->references('id')->on('produits');
            $table->foreign('unite_id')->references('id')->on('unites');
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
        Schema::dropIfExists('produit_unites');
    }
}
