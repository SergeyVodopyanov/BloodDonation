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
        Schema::create('blood_donation_stations_blood_groups', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('bloodDonationStationId');
            $table->foreign('bloodDonationStationId')->references('id')->on('blood_donation_stations')->onDelete('cascade');

            
            $table->unsignedBigInteger('bloodGroupId');
            $table->foreign('bloodGroupId')->references('id')->on('blood_groups')->onDelete('cascade');

            $table->boolean('bloodInStationEnough')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_donation_stations_blood_groups');
    }
};
