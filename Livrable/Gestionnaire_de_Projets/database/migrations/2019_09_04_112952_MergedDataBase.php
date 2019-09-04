<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergedDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->longText('description');
            $table->dateTime('limitDate');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('finishDate')->nullable()->default(null);
            $table->boolean('displacement');//true == 1 == Oui and false == 0 == Non
            $table->boolean('state');////true == 1 == en-cours and false == 0 == clos
            $table->longText('comment');
            $table->timestamps();
        });
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('title');
            $table->DateTime('limitDate');
            $table->enum('state',array('IN_PROGRESS','FINISHED','VALIDATED'));//'en-cours', 'fini', 'validé'
            $table->integer('progress');
            $table->integer('priority');//1==DoRightAway,2==PlanToDoASAP,3==Delegate,4==DumpOrPostPone
            $table->longText('comment');
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',array('ADMIN','MANAGER','PROJECT_MANAGER','EMPLOYEE'));
            $table->longText('comment');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registrationNumber',80)->unique();/*num de série..*/
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('phoneNumber',15);
            $table->longText('comment');
            $table->timestamps();
        });
        Schema::create('task_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned()->index();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->primary(['task_id','user_id']);
            $table->DateTime('startDate')->nullable();
            $table->DateTime('finishDate')->nullable();
            $table->timestamps();
        });
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
        Schema::create('Timers', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('pauseDate')->nullable();
            // $table->integer('idTask');
            $table->timestamps();
        });
        Schema::table('Timers', function(Blueprint $table)
        {
            $table->integer('idUser')->unsigned();
            $table->foreign('idUser')->references('id')
                ->on('users')->onDelete('cascade');
        });
        Schema::table('tasks', function(Blueprint $table)
        {
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade');
        });
        Schema::table('projects', function(Blueprint $table)
        {
            $table->integer('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');
        });
        Schema::table('projects', function(Blueprint $table)
        {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
        Schema::table('users',function($table){
            $table->string('avatar')->default('default.png')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('Timers');
        Schema::table('users',function($table){
            $table->dropColumn('avatar');
          });
    }
}
