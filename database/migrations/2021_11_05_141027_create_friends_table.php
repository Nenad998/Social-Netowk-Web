<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->integer('userID1')->unsigned()->index()->nullable();
            $table->foreign('userID1')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->integer('userID2')->unsigned()->index()->nullable();
            $table->foreign('userID2')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->tinyInteger('confirmed')->default(0);
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
        Schema::dropIfExists('friends');
    }
}
