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
        // ============================================================
        // ================ Location Data requirements ================
        // Nama tempat dan lokasi tambak / gudang pengepul / pasar ikan
        // ============================================================
        // ============================================================
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('kel_id');
            $table->foreign('kel_id')->references('id')->on('villages');
            $table->foreignId('user_id')->constrained(table: 'users', indexName: 'location_user_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};
