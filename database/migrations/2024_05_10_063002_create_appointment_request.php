<?php

use App\Http\Utility\Appointment\AppointmentStatusEnum;
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
        Schema::create('appointment_request', function (Blueprint $table) {
            $table->uuid('appointment_id')->primary();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->bigInteger('requester_id')->unsigned();
            $table->bigInteger('recipient_id')->unsigned();
            $table->foreign('requester_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('recipient_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', AppointmentStatusEnum::getValueArray())->default(AppointmentStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_request');
    }
};
