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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('olt_id');
            $table->foreignId('odp_id');
            $table->foreignId('paket_id');
            $table->string('onu')->unique("onu");
            $table->string('name');
            $table->string('type');
            $table->string('email');
            $table->string('hp');
            $table->string('nik');
            $table->string('foto_ktp');
            $table->string('foto_rumah');
            $table->string('status_rumah');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('sn')->nullable();
            $table->string('password');
            $table->date('active')->nullable();
            $table->date('expire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
