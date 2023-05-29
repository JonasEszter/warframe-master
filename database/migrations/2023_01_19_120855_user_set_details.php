<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSetDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_set_details", function(BluePrint $table) {
            $table->id("DetailID");
            $table->unsignedBigInteger("SetID");
            $table->tinyInteger("Place");
            $table->unsignedBigInteger("ModID")->nullable();
            $table->unsignedBigInteger("PolarityID")->nullable();
            $table->tinyInteger("ModLevel");
            $table->timestamps();
            $table->foreign("SetID")->references("SetID")->on("user_sets")->onDelete("cascade");
            $table->foreign("ModID")->references("ModID")->on("mods")->onDelete("cascade");
            $table->foreign("PolarityID")->references("TypeID")->on("polarity_types")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("user_set_details");
    }
}
