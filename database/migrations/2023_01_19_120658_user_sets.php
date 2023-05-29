<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_sets", function(BluePrint $table) {
            $table->id("SetID");
            $table->string("SetName");
            $table->unsignedBigInteger("UserID");
            $table->unsignedBigInteger("CharacterID");
            $table->timestamps();
            $table->foreign("UserID")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("CharacterID")->references("CharacterID")->on("characters")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("user_sets");
    }
}
