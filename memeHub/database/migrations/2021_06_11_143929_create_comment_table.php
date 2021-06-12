<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
          $table->engine = 'InnoDB';
            $table->id();
            $table->timestamps();
            $table->longText('comment_text');
            $table->integer('likes');
            $table->integer('dislikes');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('meme_id')->constrained('meme');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
}
