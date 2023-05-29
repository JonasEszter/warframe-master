<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CharactersModsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("characters_mods_relations", function(BluePrint $table) {
            $table->id("RelationID");
            $table->unsignedBigInteger("CharacterID");
            $table->unsignedBigInteger("ModID");
            $table->timestamps();
            $table->foreign("CharacterID")->references("CharacterID")->on("characters")->onDelete("cascade");
            $table->foreign("ModID")->references("ModID")->on("mods")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
