<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PostEventsCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_post_events_category', function (Blueprint $table) {
            $table->id();
            $table->integer('category_events_id')->unsigned()->references('id')->on('app_category_events')->onDelete('cascade');
            $table->integer('post_events_id')->unsigned()->references('id')->on('app_post_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_post_events_category');
    }
}
