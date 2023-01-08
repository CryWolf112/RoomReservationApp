<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('news_image');
            $table->text('content');
            $table->timestamp('updated_at');
            $table->charset = 'utf8';
            $table->collation = 'utf8_bin';
        });

        
        DB::table('news')->insert(
            array(
                [
                    'title' => 'Application update - location based suggestion',
                    'news_image' => 'news-globe.jpg',
                    'content' => "From now on, application suggestions of institutions will be generated base on your location. In order to assist you in searching process, we updated our algorithm. Application automatically uses your IP address to calculate your approximate location. Based on collected data we carefully choose only most suitable institutions near you. However, if you don't want our help, you can easily turn that option off in application settings menu.",
                    'updated_at' => Carbon::create(2022, 11, 3)
                ],
                [
                    'title' => 'Smart room management',
                    'news_image' => 'news-room.jpg',
                    'content' => 'Our application provide smart management. Any time users can see their institutions and rooms along with specifications and description. Users can filter data in order to find wanted information as quickest as possible with minimum effort.',
                    'updated_at' => Carbon::create(2022, 10, 26)
                ],
                [
                    'title' => 'Free chat now available',
                    'news_image' => 'news-chat.jpg',
                    'content' => 'From now on our users can communicate between each other. Chat unlimited for free using application chat option. We developed chat in order to make communication between potential lessor and tenants easy, without need for third party messengers applications. Also, every lessor is obliged to provide valid mobile phone number where users can directly contact him.',
                    'updated_at' => Carbon::create(2022, 1, 1)
                ]
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
        Schema::dropIfExists('news');
    }
};
