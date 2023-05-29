<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Characters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("characters", function(Blueprint $table) {
            $table->id("CharacterID");
            $table->string("CharName");
            $table->integer("CharPower");
            $table->integer("Health");
            $table->integer("Shield");
            $table->float("Speed");
            $table->integer("Armor");
            $table->unsignedBigInteger("Aura");
            $table->unsignedBigInteger("CompatName");
            $table->boolean("IsPrime");
            $table->string("Image");
            $table->timestamps();
            $table->foreign("Aura")->references("TypeID")->on("aura_types")->onDelete('cascade');
            $table->foreign("CompatName")->references("TypeID")->on("compat_names")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("characters");
    }
}
