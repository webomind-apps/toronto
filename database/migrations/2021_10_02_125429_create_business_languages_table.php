<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_id')->nullable()->constrained('businesses', 'id')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_languages');
    }
}
