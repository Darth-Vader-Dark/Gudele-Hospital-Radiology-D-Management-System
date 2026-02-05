<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->integer('age');
            $table->date('date_of_birth');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->enum('blood_type', ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'Unknown'])->nullable();
            $table->text('medical_history')->nullable();
            $table->text('allergies')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->index('patient_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
