<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReglementClisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reglement_clis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('commande_id')->unsigned();
            $table->DateTime('dateReg');
            $table->bigInteger('montanteVerse');
            $table->bigInteger('numeroSupport');
            $table->string('typeReg');
            $table->foreign('commande_id')->references('id')->on('commandes');
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
        Schema::dropIfExists('reglement_clis');
    }
}
