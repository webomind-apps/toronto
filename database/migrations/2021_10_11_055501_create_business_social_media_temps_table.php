<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSocialMediaTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_social_media_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_temp_id')->nullable()->constrained('business_temps', 'id')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_social_media_temps');
    }
}
