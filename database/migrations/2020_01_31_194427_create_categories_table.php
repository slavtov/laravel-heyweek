<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 100)->unique();
            $table->string('name_ru', 100)->unique();
            $table->string('name_de', 100)->unique();
            $table->string('name_fr', 100)->unique();
            $table->string('name_es', 100)->unique();
            $table->string('name_it', 100)->unique();
            $table->string('name_jp', 100)->unique();
            $table->string('name_kr', 100)->unique();
            $table->string('name_pl', 100)->unique();
            $table->string('name_cz', 100)->unique();
            $table->string('name_se', 100)->unique();
            $table->string('name_no', 100)->unique();
            $table->string('alias')->unique();
            $table->string('color', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
