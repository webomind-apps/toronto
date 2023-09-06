<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessGalleryTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_gallery_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_temp_id')->nullable()->constrained('business_temps', 'id')->onDelete('cascade');
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_gallery_temps');
    }
}
