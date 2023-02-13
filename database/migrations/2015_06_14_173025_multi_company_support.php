<?php

use Illuminate\Database\Migrations\Migration;

class MultiCompanySupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function ($table) {
            $table->increments('id');
            
            $table->unsignedInteger('user_id1')->nullable();
            $table->unsignedInteger('user_id2')->nullable();
            $table->unsignedInteger('user_id3')->nullable();
            $table->unsignedInteger('user_id4')->nullable();
            $table->unsignedInteger('user_id5')->nullable();
            $table->unsignedInteger('user_id6')->nullable();
            $table->unsignedInteger('user_id7')->nullable();
            $table->unsignedInteger('user_id8')->nullable();
            $table->unsignedInteger('user_id9')->nullable();
            $table->unsignedInteger('user_id10')->nullable();
            $table->unsignedInteger('user_id11')->nullable();
            $table->unsignedInteger('user_id12')->nullable();
            $table->unsignedInteger('user_id13')->nullable();
            $table->unsignedInteger('user_id14')->nullable();
            $table->unsignedInteger('user_id15')->nullable();
            $table->unsignedInteger('user_id16')->nullable();
            $table->unsignedInteger('user_id17')->nullable();
            $table->unsignedInteger('user_id18')->nullable();
            $table->unsignedInteger('user_id19')->nullable();
            $table->unsignedInteger('user_id20')->nullable();

            $table->foreign('user_id1')->references('id')->on('users');
            $table->foreign('user_id2')->references('id')->on('users');
            $table->foreign('user_id3')->references('id')->on('users');
            $table->foreign('user_id4')->references('id')->on('users');
            $table->foreign('user_id5')->references('id')->on('users');
            $table->foreign('user_id6')->references('id')->on('users');
            $table->foreign('user_id7')->references('id')->on('users');
            $table->foreign('user_id8')->references('id')->on('users');
            $table->foreign('user_id9')->references('id')->on('users');
            $table->foreign('user_id10')->references('id')->on('users');
            $table->foreign('user_id11')->references('id')->on('users');
            $table->foreign('user_id12')->references('id')->on('users');
            $table->foreign('user_id13')->references('id')->on('users');
            $table->foreign('user_id14')->references('id')->on('users');
            $table->foreign('user_id15')->references('id')->on('users');
            $table->foreign('user_id16')->references('id')->on('users');
            $table->foreign('user_id17')->references('id')->on('users');
            $table->foreign('user_id18')->references('id')->on('users');
            $table->foreign('user_id19')->references('id')->on('users');
            $table->foreign('user_id20')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
}
