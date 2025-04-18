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
        Schema::table('location', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropForeign('location_kel_id_foreign');
            $table->dropColumn('kel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location', function (Blueprint $table) {
            $table->string('name');
            $table->string('kel_id');
            $table->foreign('kel_id')->references('id')->on('villages');
        });
    }
};
