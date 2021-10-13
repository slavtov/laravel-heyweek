<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title_en', 500)->nullable();
            $table->string('title_ru', 500)->nullable();
            $table->string('title_de', 500)->nullable();
            $table->string('title_fr', 500)->nullable();
            $table->string('title_es', 500)->nullable();
            $table->string('title_it', 500)->nullable();
            $table->string('title_jp', 500)->nullable();
            $table->string('title_kr', 500)->nullable();
            $table->string('title_pl', 500)->nullable();
            $table->string('title_cz', 500)->nullable();
            $table->string('title_se', 500)->nullable();
            $table->string('title_no', 500)->nullable();
            $table->string('alias', 500)->unique();
            $table->text('body_en')->nullable();
            $table->text('body_ru')->nullable();
            $table->text('body_de')->nullable();
            $table->text('body_fr')->nullable();
            $table->text('body_es')->nullable();
            $table->text('body_it')->nullable();
            $table->text('body_jp')->nullable();
            $table->text('body_kr')->nullable();
            $table->text('body_pl')->nullable();
            $table->text('body_cz')->nullable();
            $table->text('body_se')->nullable();
            $table->text('body_no')->nullable();
            $table->string('img_en')->nullable();
            $table->string('img_ru')->nullable();
            $table->string('img_de')->nullable();
            $table->string('img_fr')->nullable();
            $table->string('img_es')->nullable();
            $table->string('img_it')->nullable();
            $table->string('img_jp')->nullable();
            $table->string('img_kr')->nullable();
            $table->string('img_pl')->nullable();
            $table->string('img_cz')->nullable();
            $table->string('img_se')->nullable();
            $table->string('img_no')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
