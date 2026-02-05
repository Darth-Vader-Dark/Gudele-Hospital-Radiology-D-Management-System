<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->string('medication_name');
            $table->string('dosage');
            $table->string('frequency');
            $table->integer('duration_days');
            $table->text('instructions')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->dateTime('prescribed_date');
            $table->dateTime('expiry_date');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
