<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE OR REPLACE FUNCTION update_honorary_donor()
        RETURNS TRIGGER AS $$
        BEGIN
        IF (SELECT COUNT(*) FROM donations WHERE user_id = NEW.user_id) = 40 THEN
        UPDATE users
        SET honorary_donor = NEW.date::timestamp + NEW.time::time
        WHERE id = NEW.user_id;
        END IF;
        RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
    ');

    DB::unprepared('
        CREATE TRIGGER check_donations_trigger
        AFTER INSERT ON donations
        FOR EACH ROW
        EXECUTE FUNCTION update_honorary_donor();
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS check_donations_trigger ON donations;');

        DB::unprepared('DROP FUNCTION IF EXISTS update_honorary_donor();');
    }
};
