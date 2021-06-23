<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemeKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meme_keyword', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('keyword_id')->constrained('keywords');
            $table->foreignId('meme_id')->constrained('memes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meme_keyword');
    }
}
