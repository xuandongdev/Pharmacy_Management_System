<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tạo bảng suppliers (Nhà cung cấp)
        Schema::create('suppliers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->notNull(); // Tên nhà cung cấp
            $table->string('contact_name', 255)->nullable(); // Tên người liên hệ
            $table->string('phone', 15)->nullable(); // Số điện thoại
            $table->string('email', 255)->nullable(); // Email liên hệ
            $table->text('address')->nullable(); // Địa chỉ
            $table->timestamps();
        });

        // Tạo bảng warehouses (Kho)
        Schema::create('warehouses', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->notNull(); // Tên kho
            $table->string('location', 255)->nullable(); // Địa điểm kho
            $table->timestamps();
        });

        // Tạo bảng warehouse_details (Chi tiết kho - Sản phẩm trong kho)
        Schema::create('warehouse_details', function (Blueprint $table) {
            $table->integer('warehouse_id')->notNull();
            $table->integer('medicine_id')->notNull();
            $table->integer('quantity_in_stock')->notNull(); // Số lượng tồn kho của sản phẩm
            $table->decimal('purchase_price', 15, 2)->notNull(); // Giá nhập của sản phẩm

            $table->primary(['warehouse_id', 'medicine_id']);
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });

        // Tạo bảng supplier_product (Sản phẩm của nhà cung cấp)
        Schema::create('supplier_product', function (Blueprint $table) {
            $table->integer('supplier_id')->notNull();
            $table->integer('medicine_id')->notNull();
            $table->decimal('purchase_price', 15, 2)->notNull(); // Giá nhập từ nhà cung cấp
            $table->integer('lead_time_days')->default(0); // Thời gian giao hàng từ nhà cung cấp

            $table->primary(['supplier_id', 'medicine_id']);
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('supplier_product');
        Schema::dropIfExists('warehouse_details');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('suppliers');
    }
};
