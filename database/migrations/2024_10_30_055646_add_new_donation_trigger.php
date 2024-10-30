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
        CREATE OR REPLACE FUNCTION check_last_donation_date()
        RETURNS TRIGGER AS $$
        DECLARE
        last_donation_date DATE;
        BEGIN
        SELECT MAX(date) INTO last_donation_date
        FROM donations
        WHERE user_id = NEW.user_id;
        IF last_donation_date IS NOT NULL AND NEW.date < last_donation_date + INTERVAL \'2 months\' THEN
            RAISE EXCEPTION \'После оследней донации должно пройти 2 месяца\';
        END IF;
        RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
    ');

        DB::unprepared('
            CREATE TRIGGER before_insert_donation
            BEFORE INSERT ON donations
            FOR EACH ROW
            EXECUTE FUNCTION check_last_donation_date();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_donation ON donations;');

        DB::unprepared('DROP FUNCTION IF EXISTS check_last_donation_date();');
    }
};
