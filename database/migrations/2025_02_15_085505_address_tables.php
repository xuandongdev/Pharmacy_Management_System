<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->string('province_name')->primary();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->string('district_name')->primary();
            $table->string('province_name');
            $table->foreign('province_name')->references('province_name')->on('provinces')->onDelete('cascade');
        });

        Schema::create('communes', function (Blueprint $table) {
            $table->string('commune_name')->primary();
            $table->string('district_name');
            $table->foreign('district_name')->references('district_name')->on('districts')->onDelete('cascade');
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id('address_id');
            $table->string('commune');
            $table->string('street')->nullable();
            $table->string('number_house')->nullable();
            $table->string('details')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->foreign('commune')->references('commune_name')->on('communes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('communes');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
};