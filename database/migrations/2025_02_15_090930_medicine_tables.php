<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tạo bảng promotion_types
        Schema::create('promotion_types', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->unique()->notNull();
            $table->string('description', 255)->notNull();
        });

        // Tạo bảng promotions
        Schema::create('promotions', function (Blueprint $table) {
            $table->integer('id')->primary(); // Đảm bảo sử dụng integer cho cột 'id'
            $table->string('title', 255)->notNull();
            $table->string('description', 255)->notNull();
            $table->date('start_date')->notNull();
            $table->date('end_date')->notNull();
            $table->integer('admin_id')->notNull();
            $table->integer('promotion_type_id')->notNull(); // Sử dụng integer cho 'promotion_type_id'

            $table->foreign('promotion_type_id')->references('id')->on('promotion_types')->cascadeOnDelete();
        });

        // Tạo bảng promotion_details
        Schema::create('promotion_details', function (Blueprint $table) {
            $table->integer('promotion_id')->notNull(); // Đảm bảo sử dụng integer cho cột 'promotion_id'
            $table->integer('medicine_id')->notNull(); // Sửa lại tên cột 'medicine_id'

            $table->primary(['promotion_id', 'medicine_id']);
            $table->foreign('promotion_id')->references('id')->on('promotions')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('promotion_details');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('promotion_types');
    }
};
