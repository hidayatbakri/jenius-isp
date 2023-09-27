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
        Schema::create('odc', function (Blueprint $table) {
            $table->id();
            $table->string("olt_id");
            $table->string("name");
            $table->string("head");
            $table->string("address");
            $table->string("description");
            $table->string("foto");
            $table->integer("port");
            $table->string("latitude");
            $table->string("longitude");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odc');
    }
};
