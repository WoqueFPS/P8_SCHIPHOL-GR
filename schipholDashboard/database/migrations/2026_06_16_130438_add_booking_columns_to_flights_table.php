<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            // Check of kolommen bestaan voordat we ze toevoegen
            if (!Schema::hasColumn('flights', 'seats_available')) {
                $table->integer('seats_available')->default(100)->after('delay_minutes');
            }
            if (!Schema::hasColumn('flights', 'price')) {
                $table->decimal('price', 10, 2)->default(99.99)->after('seats_available');
            }
        });
    }

    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn(['seats_available', 'price']);
        });
    }
};