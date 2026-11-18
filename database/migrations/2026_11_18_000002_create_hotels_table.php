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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('country')->default('Pakistan');
            $table->string('address');
            $table->unsignedTinyInteger('star_rating')->default(4); // 1-5
            $table->decimal('price_per_night', 10, 2);
            $table->integer('total_rooms')->default(20);
            $table->integer('available_rooms')->default(20);
            $table->json('room_types')->nullable(); // e.g. ["Standard Room", "Deluxe Suite", "Executive Room"]
            $table->json('amenities')->nullable(); // e.g. ["Free WiFi", "Swimming Pool", "Breakfast", "AC"]
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
