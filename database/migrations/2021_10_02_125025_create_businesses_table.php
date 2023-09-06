<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('transaction_id')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('country_id')->nullable()->constrained('countries', 'id')->onDelete('cascade');
            $table->foreignId('province_id')->nullable()->constrained('provinces', 'id')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities', 'id')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->string('postcode')->nullable();
            $table->text('address')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('website')->nullable();
            $table->text('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('is_feature')->default('0')->comment('1-active 0-inactive');
            $table->longText('area_of_practice')->nullable();
            $table->longText('product_and_service')->nullable();
            $table->longText('specialization')->nullable();
            $table->integer('priority')->nullable();
            $table->boolean('online_order')->default('1')->comment('0-no,1-yes');
            $table->string('online_order_link')->nullable();
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
        Schema::dropIfExists('businesses');
    }
}
