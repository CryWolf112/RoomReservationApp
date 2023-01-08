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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 56);
            $table->charset='utf8';
            $table->collation='utf8_bin';
        });

        DB::table('countries')->insert(
            array(
                ['name' => 'Croatia'],
                ['name' => 'Austria'],
                ['name' => 'Germany'],
                ['name' => 'France'],
                ['name' => 'Spain'],
                ['name' => 'Switzerland'],
                ['name' => 'Italy'],
                ['name' => 'Slovenia'],
                ['name' => 'Romania'],
                ['name' => 'Poland']
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
        Schema::dropIfExists('countries');
    }
};
