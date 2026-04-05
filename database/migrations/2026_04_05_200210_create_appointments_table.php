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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('sequence_number')->autoIncrement(false);
            // ^ auto sequence per year, or just use id as sequence
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->dateTime('appointment_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed'])
                ->default('pending');
                // pending   = تحت الإجراء
                // completed = انتهى الإجراء
            $table->timestamps();

            $table->index('appointment_date');       // fast calendar queries
            $table->index(['status', 'appointment_date']); // fast status filter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
