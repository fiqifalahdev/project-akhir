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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // ============= User Data requirements ================
            $table->string('name');
            $table->string('phone');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // ============ Additional Data for Profile ============
            // Alamat rumah user
            $table->string('address')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('kel_id')->nullable();
            $table->foreign('kel_id')->references('id')->on('villages');
            // Tentang user
            $table->string('about')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
