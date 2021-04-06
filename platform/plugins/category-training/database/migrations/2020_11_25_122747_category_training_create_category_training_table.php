<?php

use Platform\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CategoryTrainingCreateCategoryTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_category_training', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id')->nullable();
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_default')->unsigned()->default(0);
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
        Schema::dropIfExists('app_category_training');
    }
}
