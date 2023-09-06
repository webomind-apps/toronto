<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('banner_id')->nullable()->constrained('banners', 'id')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_cities');
    }
}
