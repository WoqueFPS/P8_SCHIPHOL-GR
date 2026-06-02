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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->string('airline');
            $table->string('airline_code', 4);
            $table->string('origin');
            $table->string('destination');
            $table->string('gate', 10)->nullable();
            $table->string('terminal', 10)->nullable();
            $table->enum('type', ['arriving', 'departing']);
            $table->enum('status', ['op-tijd', 'vertraging', 'boarding', 'geland', 'geannuleerd']);
            $table->time('scheduled_time');
            $table->integer('delay_minutes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
