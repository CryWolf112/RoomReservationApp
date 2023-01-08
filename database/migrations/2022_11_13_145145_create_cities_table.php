<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->charset='utf8';
            $table->collation='utf8_bin';
        });

        DB::table('cities')->insert(
            array(
                ['name' => 'Zagreb', 'country_id' => 1],
                ['name' => 'Vienna', 'country_id' => 2],
                ['name' => 'Berlin', 'country_id' => 3],
                ['name' => 'Paris', 'country_id' => 4],
                ['name' => 'Madrid', 'country_id' => 5],
                ['name' => 'Bern', 'country_id' => 6],
                ['name' => 'Rome', 'country_id' => 7],
                ['name' => 'Ljubljana', 'country_id' => 8],
                ['name' => 'Bucharest', 'country_id' => 9],
                ['name' => 'Warsaw', 'country_id' => 10]
            )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
