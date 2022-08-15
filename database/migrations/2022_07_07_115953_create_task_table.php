<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tasks", function (Blueprint $table) {
            $table->id("task_id");
            $table->text("task_name");
            $table->text("task_status");
            $table->datetime("task_assign_date");
            $table->datetime("task_start_date")->nullable();
            $table->datetime("task_end_date")->nullable();
            $table->foreignId("staff_id")->constraints();
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
        Schema::dropIfExists("tasks");
    }
};
