<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 256)->nullable();
            $table->string('link', 256);
            $table->text('description')->nullable();
            $table->enum('type', ['rss', 'atom', 'html'])->default('rss');
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('fetch_frequency')->default(60);
            $table->unsignedBigInteger('source_id')->nullable();
            $table->timestampTz('last_build_date')->nullable();
            $table->text('xml')->nullable();
            $table->timestampTz('last_synced_at')->nullable();
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
        Schema::dropIfExists('feeds');
    }
}
