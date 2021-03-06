<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LibraryCategoryCreateLibraryCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_library_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('description', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('status', 60)->default('published');
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
        Schema::dropIfExists('app_library_categories');
    }
}
