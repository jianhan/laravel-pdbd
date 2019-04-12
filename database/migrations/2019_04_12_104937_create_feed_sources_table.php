<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url', 256);
            $table->string('name', 256);
            $table->enum('type', ['rss', 'atom', 'html'])->default('rss');
            $table->string('site_url', 256)->nullable();
            $table->string('logo', 128)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('fetch_frequency')->default(60);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_sources');
    }
}
