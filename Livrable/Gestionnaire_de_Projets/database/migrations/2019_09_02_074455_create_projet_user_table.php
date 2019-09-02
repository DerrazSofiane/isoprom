<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('projet_user', function (Blueprint $table) {

           $table->integer('user_id')->unsigned()->index();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

           $table->integer('projet_id')->unsigned()->index();
           $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');

        $table->primary(['projet_id','user_id']);
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projet_user');
    }
}
