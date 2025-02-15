<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tạo bảng revenue_reports (Báo cáo doanh thu)
        Schema::create('revenue_reports', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('report_date')->notNull(); // Ngày báo cáo
            $table->decimal('total_revenue', 15, 2)->notNull(); // Tổng doanh thu
            $table->decimal('total_cost', 15, 2)->notNull(); // Tổng chi phí
            $table->decimal('net_profit', 15, 2)->notNull(); // Lợi nhuận ròng
            $table->timestamps();
        });

        // Tạo bảng occupancy_reports (Báo cáo tỷ lệ lấp đầy)
        Schema::create('occupancy_reports', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('report_date')->notNull(); // Ngày báo cáo
            $table->integer('total_seats')->notNull(); // Tổng số ghế (hoặc sân, hoặc bất kỳ đơn vị nào khác)
            $table->integer('occupied_seats')->notNull(); // Số ghế đã đặt
            $table->decimal('occupancy_rate', 5, 2)->notNull(); // Tỷ lệ lấp đầy (occupied_seats / total_seats)
            $table->timestamps();
        });

        // Tạo bảng sales_reports (Báo cáo doanh số)
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('report_date')->notNull(); // Ngày báo cáo
            $table->integer('total_orders')->notNull(); // Tổng số đơn hàng
            $table->decimal('total_sales', 15, 2)->notNull(); // Tổng doanh thu từ bán hàng
            $table->decimal('total_discount', 15, 2)->default(0); // Tổng giảm giá
            $table->timestamps();
        });

        // Tạo bảng inventory_reports (Báo cáo tồn kho)
        Schema::create('inventory_reports', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->date('report_date')->notNull(); // Ngày báo cáo
            $table->integer('total_products')->notNull(); // Tổng số sản phẩm
            $table->integer('products_in_stock')->notNull(); // Số sản phẩm còn trong kho
            $table->integer('products_out_of_stock')->notNull(); // Số sản phẩm hết hàng
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventory_reports');
        Schema::dropIfExists('sales_reports');
        Schema::dropIfExists('occupancy_reports');
        Schema::dropIfExists('revenue_reports');
    }
};
