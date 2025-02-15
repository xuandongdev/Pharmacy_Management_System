<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tạo bảng promotions
        Schema::create('promotions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->notNull();
            $table->decimal('discount_percentage', 5, 2)->notNull();
            $table->date('start_date')->notNull();
            $table->date('end_date')->notNull();
            $table->integer('admin_id')->notNull();

            $table->foreign('admin_id')->references('id')->on('administrators')->cascadeOnDelete();
        });

        // Tạo bảng promotion_details
        Schema::create('promotion_details', function (Blueprint $table) {
            $table->integer('promotion_id')->notNull();
            $table->integer('medicine_id')->notNull();
            $table->integer('quantity')->notNull();

            $table->primary(['promotion_id', 'medicine_id']);
            $table->foreign('promotion_id')->references('id')->on('promotions')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('promotion_details');
        Schema::dropIfExists('promotions');
    }
};
