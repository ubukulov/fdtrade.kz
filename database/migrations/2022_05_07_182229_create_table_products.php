<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('article')->nullable();
            $table->string('name')->nullable();
            $table->string('full_name', 1500)->nullable();
            $table->integer('sort')->nullable();
            $table->integer('price1')->nullable();
            $table->integer('price2')->nullable();
            $table->integer('price')->nullable();
            $table->string('quantity')->nullable();
            $table->tinyInteger('isnew')->nullable();
            $table->tinyInteger('ishit')->nullable();
            $table->tinyInteger('ispromo')->nullable();
            $table->string('article_pn')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
