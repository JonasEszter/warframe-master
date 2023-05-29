<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModEffectTypeRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("mod_effect_type_relations", function(BluePrint $table) {
            $table->id("RelationID");
            $table->unsignedBigInteger("EffectType");
            $table->unsignedBigInteger("ModID");
            $table->float("EffectValue");
            $table->integer("ModLevel");
            $table->timestamps();
            $table->foreign("EffectType")->references("TypeID")->on("effect_types")->onDelete("cascade");
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
        Schema::drop("mod_effect_type_relations");
    }
}
