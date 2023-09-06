<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_id')->nullable()->constrained('businesses', 'id')->onDelete('cascade');
            $table->integer('feature')->default('0')->comment('1-300 banner,2-600-banner,3-listing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_features');
    }
}
