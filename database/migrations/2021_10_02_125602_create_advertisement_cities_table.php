<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('advertisement_id')->nullable()->constrained('advertisements', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('advertisement_cities');
    }
}
