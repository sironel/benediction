<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_commandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('commande_id')->unsigned();
            $table->bigInteger('prix_vente_id')->unsigned();
            $table->double('quantiteProdCom');
            $table->boolean('livrer');
            $table->foreign('commande_id')->references('id')->on('commandes');
            $table->foreign('prix_vente_id')->references('id')->on('prix_ventes');
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
        Schema::dropIfExists('detail_commandes');
    }
}
