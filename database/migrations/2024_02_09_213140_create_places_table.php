<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id('id');
            $table->string('url')->unique();
            $table->boolean('is_favorite')->default(false);
            $table->integer('is_lite')->default(0);
            $table->integer('is_classic')->default(0);
            $table->boolean('is_amex')->default(false);
            $table->boolean('has_delivery')->default(false);
            $table->string('image_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('name');
            $table->string('shortName');
            $table->string('main_category')->nullable();
            $table->string('categories');
            $table->string('schedule')->nullable();
            $table->integer('score')->default(0);
            $table->string('price_range');
            $table->string('location');
            $table->json('position');
            $table->boolean('isOutstanding')->default(0);
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
        Schema::dropIfExists('places');
    }
}
