<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fournisseur_id')->unsigned();
            $table->bigInteger('produit_id')->unsigned();
            $table->double('prix');
            $table->double('frais');
            $table->integer('profit');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('restrict');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('restrict');
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
        Schema::dropIfExists('achats');
    }
}
