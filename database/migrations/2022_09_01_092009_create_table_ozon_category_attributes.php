<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOzonCategoryAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ozon_category_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ozon_category_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('name');
            $table->text('description');
            $table->string('type');
            $table->boolean('is_collection');
            $table->boolean('is_required');
            $table->integer('group_id');
            $table->string('group_name');
            $table->unsignedBigInteger('dictionary_id');

            $table->timestamps();

            $table->foreign('ozon_category_id')
                ->references('id')
                ->on('ozon_categories')
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
        Schema::dropIfExists('ozon_category_characteristics');
    }
}
