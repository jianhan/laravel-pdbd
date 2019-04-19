<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 1024);
            $table->string('link', 1024);
            $table->text('description');
            $table->text('content')->nullable();
            $table->timestampTz('pub_date');
            $table->string('hashed_public_id', 32);
            $table->string('creator', 256);
            $table->integer('timestamp');
            $table->unsignedBigInteger('feed_id')->nullable();
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
        Schema::dropIfExists('items');
    }
}
