<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TodoProgresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("todo_progresses", function(BluePrint $table) {
            $table->id("ProgressID");
            $table->unsignedBigInteger("UserID");
            $table->unsignedBigInteger("ListItem");
            $table->timestamps();
            $table->foreign("UserID")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("ListItem")->references("ItemID")->on("todo_list_items")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("todo_progresses");
    }
}
