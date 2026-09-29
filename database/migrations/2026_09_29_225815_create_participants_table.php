<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->string('name', 191);
            $table->string('email', 191)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('ic_number', 50)->nullable();
            $table->string('passport_number', 50)->nullable();
            $table->string('passport_file', 191)->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};