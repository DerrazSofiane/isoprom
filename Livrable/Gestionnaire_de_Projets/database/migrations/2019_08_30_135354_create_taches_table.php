<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description');
            $table->DateTime('date_limite');
            $table->enum('état',array('en-cours','fini','validée','non-validée'));
                    $table->enum('type',array('final','non-final'));
                    $table->integer('déroulement'); /* avec % */
                    $table->integer('priorité'); /* de 0....*  colors red...green*/
            $table->longText('commentaire');
            $table->rememberToken();
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
        Schema::dropIfExists('taches');
    }
}
