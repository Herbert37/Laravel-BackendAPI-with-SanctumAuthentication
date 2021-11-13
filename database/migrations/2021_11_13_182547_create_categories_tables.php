<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->float('price_range', 8, 2);
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')
                ->references('id')
                ->on('subcategories')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
    }
}
