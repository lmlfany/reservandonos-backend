<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('place_details', function (Blueprint $table) {
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->string('slug');
            $table->boolean('is_lite');
            $table->boolean('is_classic');
            $table->boolean('is_favorite');
            $table->boolean('is_amex');
            $table->boolean('isOutstanding');
            $table->boolean('has_delivery');
            $table->integer('reservable');
            $table->string('name');
            $table->text('description');
            $table->string('main_img');
            $table->string('logo_img');
            $table->json('gallery');
            $table->string('range_price');
            $table->boolean('status');
            $table->json('schedules');
            $table->json('amenities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_details');
    }
};
