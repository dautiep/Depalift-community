<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PostTrainingCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_post_training_category', function (Blueprint $table) {
            $table->id();
            $table->integer('category_training_id')->unsigned()->references('id')->on('app_category_training')->onDelete('cascade');
            $table->integer('post_training_id')->unsigned()->references('id')->on('app_post_trainings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_post_training_category');
    }
}
