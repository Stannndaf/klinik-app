<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->foreignId('slot_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('source', ['online', 'walkin']);

            $table->enum('status', [
                'booked',
                'waiting',
                'called',
                'done',
                'cancelled'
            ])->default('booked');

            $table->integer('queue_number')->nullable();
            $table->dateTime('checkin_time')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};