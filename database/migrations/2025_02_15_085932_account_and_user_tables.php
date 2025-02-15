<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Bảng trạng thái tài khoản
        Schema::create('account_statuses', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 50)->unique();
        });

        // 2. Bảng hạng tài khoản
        Schema::create('account_ranks', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 50)->unique();
            $table->integer('min_points')->default(0);
        });

        // 3. Bảng loại tài khoản
        Schema::create('account_types', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 50)->unique();
        });

        // 4. Bảng khách hàng
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('full_name', 255);
            $table->integer('loyalty_points')->default(0);
        });

        // 5. Bảng tài khoản
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('username', 255)->unique();
            $table->string('password_hash', 255);
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('status_id')->default(1);
            $table->integer('rank_id')->default(1);
            $table->integer('account_type_id');
            $table->timestamp('created_at')->useCurrent();

            // Ràng buộc khóa ngoại
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('account_statuses')->cascadeOnDelete();
            $table->foreign('rank_id')->references('id')->on('account_ranks')->cascadeOnDelete();
            $table->foreign('account_type_id')->references('id')->on('account_types')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('account_types');
        Schema::dropIfExists('account_ranks');
        Schema::dropIfExists('account_statuses');
    }
};
