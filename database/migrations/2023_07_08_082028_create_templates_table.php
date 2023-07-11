<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->integer('canvas_width');
            $table->integer('canvas_height');
            $table->integer('profile_x');
            $table->integer('profile_y');
            $table->integer('textContents_0_x');//stundent no
            $table->integer('textContents_0_y');//stundent no
            $table->integer('textContents_1_x');//course
            $table->integer('textContents_1_y');//course
            $table->integer('textContents_2_x');//last name
            $table->integer('textContents_2_y');//last name
            $table->integer('textContents_3_x');//first name
            $table->integer('textContents_3_y');//first name
            $table->integer('textContents_4_x');//middle name
            $table->integer('textContents_4_y');//middle name
            // add more later including the font
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
        Schema::dropIfExists('templates');
    }
};
