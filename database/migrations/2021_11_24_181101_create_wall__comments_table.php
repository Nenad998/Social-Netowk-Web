<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wall__comments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->integer('wall_id')->unsigned()->index()->nullable();
            $table->foreign('wall_id')->references('id')->on('walls')->constrained()->onDelete('cascade');

            $table->string('comment');
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
        Schema::dropIfExists('wall__comments');
    }
}
