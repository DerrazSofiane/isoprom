<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('intitulee',100)->unique();
            $table->longText('description');
            $table->dateTime('date_limite');
              $table->dateTime('date_debut');
                $table->dateTime('date_fin');
                  $table->enum('deplacement',array('O','N'));
                    $table->integer('deroulement');
                      $table->string('responsable');
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
        Schema::dropIfExists('projets');
    }
}
