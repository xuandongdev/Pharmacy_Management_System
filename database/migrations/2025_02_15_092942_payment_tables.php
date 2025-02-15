<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tạo bảng payment_methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->notNull(); // Tên phương thức thanh toán (ví dụ: thẻ tín dụng, tiền mặt)
            $table->string('description', 255)->nullable(); // Mô tả phương thức thanh toán (tuỳ chọn)
        });

        // Tạo bảng payments
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('order_id')->notNull(); // Liên kết với đơn hàng
            $table->integer('payment_method_id')->notNull(); // Liên kết với phương thức thanh toán
            $table->decimal('amount', 15, 2)->notNull(); // Số tiền thanh toán
            $table->dateTime('payment_date')->default(now()); // Ngày thanh toán

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->cascadeOnDelete();
        });

        // Tạo bảng order_payments (nếu có nhiều phương thức thanh toán cho mỗi đơn hàng)
        Schema::create('order_payments', function (Blueprint $table) {
            $table->integer('order_id')->notNull();
            $table->integer('payment_id')->notNull();
            $table->primary(['order_id', 'payment_id']);
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('payment_id')->references('id')->on('payments')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_methods');
    }
};
