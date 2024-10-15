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
        Schema::create('blood_donation_stations', function (Blueprint $table) {
            $table->id();
            $table->string('bloodDonationStationTitle');
            $table->string('bloodDonationStationAddress');
            $table->string('bloodDonationStationGeolocation');

            $table->unsignedBigInteger('cityId')->nullable(); 
            $table->foreign('cityId')->references('id')->on('cities')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_donation_stations');
    }
};
