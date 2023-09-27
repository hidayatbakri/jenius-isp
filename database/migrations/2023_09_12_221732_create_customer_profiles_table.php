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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('olt_id');
            $table->string('onuinterface');
            $table->string('name');
            $table->string('type');
            $table->string('state');
            $table->string('configuredchannel');
            $table->string('currentchannel');
            $table->string('adminstate');
            $table->string('phasestate');
            $table->string('configstate');
            $table->string('authenticationmode');
            $table->string('snbind');
            $table->string('serialnumber');
            $table->string('password')->nullable();
            $table->string('description');
            $table->string('vportmode');
            $table->string('dbamode');
            $table->string('onustatus');
            $table->string('omcibwprofile')->nullable();
            $table->string('lineprofile')->nullable();
            $table->string('serviceprofile')->nullable();
            $table->string('onudistance');
            $table->string('onlineduration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
