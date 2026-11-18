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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique(); // e.g. TRV-2026-XXXX
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['flight', 'hotel', 'package']);
            
            // Related item FKs
            $table->foreignId('flight_id')->nullable()->constrained('flights')->nullOnDelete();
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            
            // Schedule & Dates
            $table->date('travel_date')->nullable(); // For flight or package departure
            $table->date('check_in_date')->nullable(); // For hotel
            $table->date('check_out_date')->nullable(); // For hotel
            $table->integer('guests_count')->default(1);
            $table->string('room_type')->nullable(); // For hotel
            $table->string('seat_class')->nullable(); // For flight
            $table->string('seat_number')->nullable(); // For flight

            // Passenger / Guest Details
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->json('passenger_details')->nullable(); // list of passengers (name, age, cnic/passport)

            // Pricing & Breakdown
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);

            // Statuses
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded', 'partial_refund'])->default('unpaid');
            $table->enum('status', ['confirmed', 'pending', 'cancelled', 'completed'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
