<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LibraryDocumentCreateLibraryDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_library_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('description', 190)->nullable();
            $table->string('thumbnail', 191)->nullable();
            $table->unsignedInteger('library_category_id')->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();

            $table->foreign('library_category_id')->references('id')->on('app_library_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_library_documents');
    }
}
