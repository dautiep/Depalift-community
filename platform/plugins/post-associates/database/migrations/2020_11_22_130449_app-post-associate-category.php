<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppPostAssociateCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_post_associates_category', function (Blueprint $table) {
            $table->id();
            $table->integer('category_associates_id')->unsigned()->references('id')->on('app_category_associates')->onDelete('cascade');
            $table->integer('post_associates_id')->unsigned()->references('id')->on('app_post_associates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_post_associates_category');
    }
}
