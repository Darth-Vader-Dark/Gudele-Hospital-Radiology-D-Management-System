<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->string('test_type');
            $table->text('findings');
            $table->text('diagnosis');
            $table->text('recommendations')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', ['pending', 'completed', 'reviewed'])->default('pending');
            $table->dateTime('test_date');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->index('test_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_results');
    }
};
