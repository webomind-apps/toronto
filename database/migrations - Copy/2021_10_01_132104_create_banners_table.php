<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('business_id')->nullable()->constrained('businesses', 'id')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->string('link')->nullable();
            $table->double('price')->default('0');
            $table->date('expired_date')->nullable();
            $table->boolean('status')->default('1')->comment('1-active 0-inactive');
            $table->integer('created_by')->default('0')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('updated_by')->default('0')->unsigned();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}