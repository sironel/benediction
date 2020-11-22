<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_proformas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('proforma_id')->unsigned();
            $table->bigInteger('prix_vente_id')->unsigned();
            $table->double('quantiteProd');
            $table->foreign('proforma_id')->references('id')->on('proformas');
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
        Schema::dropIfExists('detail_proformas');
    }
}
