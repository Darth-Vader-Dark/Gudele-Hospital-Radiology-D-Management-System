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
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('appointment_type');
            $table->dateTime('scheduled_date');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no-show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('reason_for_visit')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('scheduled_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
