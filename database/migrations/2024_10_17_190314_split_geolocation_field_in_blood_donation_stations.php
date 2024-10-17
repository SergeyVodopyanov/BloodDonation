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
        Schema::table('blood_donation_stations', function (Blueprint $table) {
            $table->string('bloodDonationStationLatitude')->nullable();
            $table->string('bloodDonationStationLongitude')->nullable();

            $table->dropColumn('bloodDonationStationGeolocation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_donation_stations', function (Blueprint $table) {
            $table->string('bloodDonationStationGeolocation')->nullable();

            $table->dropColumn(['bloodDonationStationLatitude', 'bloodDonationStationLongitude']);
        });
    }
};
