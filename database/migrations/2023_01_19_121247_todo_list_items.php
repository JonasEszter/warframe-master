<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TodoListItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("todo_list_items", function(BluePrint $table) {
            $table->id("ItemID");
            $table->string("ItemName");
            $table->unsignedBigInteger("ItemLevel");
            $table->timestamps();
            $table->foreign("ItemLevel")->references("LevelID")->on("todo_levels")->onDelete("cascade");
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
