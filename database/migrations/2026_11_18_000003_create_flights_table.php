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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline');
            $table->string('flight_number')->unique();
            $table->string('origin_city');
            $table->string('destination_city');
            $table->string('origin_airport');
            $table->string('destination_airport');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('duration'); // e.g. "1h 50m"
            $table->enum('seat_class', ['Economy', 'Business', 'First Class'])->default('Economy');
            $table->integer('total_seats')->default(150);
            $table->integer('available_seats')->default(150);
            $table->decimal('price_per_seat', 10, 2);
            $table->string('baggage_allowance')->default('20 KG Checked + 7 KG Cabin');
            $table->string('aircraft_type')->nullable(); // e.g. "Airbus A320", "Boeing 777"
            $table->string('image')->nullable();
            $table->enum('status', ['scheduled', 'delayed', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
