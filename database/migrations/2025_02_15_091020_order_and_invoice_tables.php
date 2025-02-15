<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 50)->unique()->notNull();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->dateTime('order_date')->default(now());
            $table->decimal('total_amount', 15, 2)->notNull();
            $table->integer('status_id')->notNull();

            $table->foreign('status_id')->references('id')->on('order_statuses')->cascadeOnDelete();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('order_id')->notNull();
            $table->integer('medicine_id')->notNull();
            $table->integer('quantity')->notNull();
            $table->decimal('sales_price', 15, 2)->notNull();

            $table->primary(['order_id', 'medicine_id']);
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });

        Schema::create('invoice_statuses', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 255)->notNull();
            $table->string('description', 255)->notNull();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->dateTime('issue_date')->default(now());
            $table->date('due_date')->notNull();
            $table->decimal('total_paid', 15, 2)->notNull();
            $table->integer('order_id')->unique()->notNull();
            $table->integer('status_id')->notNull();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('invoice_statuses')->cascadeOnDelete();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->integer('invoice_id')->notNull();
            $table->integer('medicine_id')->notNull();
            $table->integer('quantity')->notNull();
            $table->decimal('sales_price', 15, 2)->notNull();

            $table->primary(['invoice_id', 'medicine_id']);
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_statuses');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_statuses');
    }
};
