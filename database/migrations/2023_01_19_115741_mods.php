<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("mods", function(BluePrint $table) {
            $table->id("ModID");
            $table->string("ModName");
            $table->unsignedBigInteger("Polarity");
            $table->string("ModImg")->nullable();
            $table->boolean("IsPrime");
            $table->mediumInteger("BaseDrain");
            $table->unsignedBigInteger("CompatName");
            $table->timestamps();
            $table->foreign("Polarity")->references("TypeID")->on("polarity_types")->onDelete("cascade");
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
        Schema::dropIfExists("mods");
    }
}
