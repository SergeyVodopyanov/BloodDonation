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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Поликлиника ' . rand(1, 100));
            $table->string('city');
            $table->string('address');
            $table->string('geolocation');
            $table->integer('first_blood_group_count');
            $table->integer('second_blood_group_count');
            $table->integer('third_blood_group_count');
            $table->integer('fourth_blood_group_count');
            $table->integer('enough_count')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
