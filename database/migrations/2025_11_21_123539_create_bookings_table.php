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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('car_id')
                ->constrained('cars')
                ->onDelete('cascade');
                
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->string('destination')->nullable();
            $table->text('purpose')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                ->default('pending');
                
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['car_id', 'start_time', 'end_time']);
            $table->index(['user_id', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
