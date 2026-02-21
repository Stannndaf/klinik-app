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
    Schema::create('queues', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('doctor_id')->constrained()->onDelete('cascade');

        $table->integer('queue_number'); // nomor antrian
        $table->date('queue_date'); // reset per hari

        $table->enum('status', [
            'waiting',
            'called',
            'skipped',
            'done'
        ])->default('waiting');

        $table->timestamps();

        // supaya tidak ada nomor ganda di hari yang sama untuk dokter yang sama
        $table->unique(['doctor_id', 'queue_number', 'queue_date']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
