<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToRssFeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss_feeds', function (Blueprint $table) {
            $table->foreign('rss_feed_id', 'rss_feed_id_fk')->references('id')->on('rss_feeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rss_feeds', function (Blueprint $table) {
            $table->dropForeign('rss_feed_id_fk');
        });
    }
}
