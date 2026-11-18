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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('destination');
            $table->string('country')->default('Pakistan');
            $table->integer('duration_days')->default(5);
            $table->integer('duration_nights')->default(4);
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->foreignId('flight_id')->nullable()->constrained('flights')->nullOnDelete();
            $table->decimal('price', 10, 2);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->integer('max_capacity')->default(30);
            $table->integer('available_slots')->default(30);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->json('itinerary')->nullable(); // [{"day": 1, "title": "...", "details": "..."}, ...]
            $table->json('inclusions')->nullable(); // ["Luxury Hotel", "Daily Breakfast", "Sightseeing Tour"]
            $table->json('exclusions')->nullable(); // ["Visa fees", "Personal expenses"]
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
