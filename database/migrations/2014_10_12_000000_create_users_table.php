<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('first_name', 35)->nullable();
            $table->string('last_name', 35)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 6)->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->string('username', 32)->unique();
            $table->string('email', 320)->unique();
            $table->string('password');
            $table->boolean('account_confirmed')->default(false);
            $table->timestamp('date_created')->useCurrent();
            $table->rememberToken();
            $table->foreignId('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->charset='utf8';
            $table->collation='utf8_bin';
        });

        DB::table('users')->insert([
            'id' => '1',
            'username' => 'admin',
            'email' => 'default77@default.com',
            'password' => Hash::make('admin'),
            'account_confirmed' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
