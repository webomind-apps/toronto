<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessCategoryTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_category_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_temp_id')->nullable()->constrained('business_temps', 'id')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_category_temps');
    }
}
