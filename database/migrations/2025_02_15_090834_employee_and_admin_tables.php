<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('salaries', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->decimal('base_salary', 15, 2)->notNull();
            $table->decimal('bonus', 15, 2)->default(0);
            $table->date('effective_date')->notNull();
        });

        Schema::create('pharmacists', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('full_name', 255)->notNull();
            $table->string('license_number', 255)->unique()->nullable();
            $table->integer('degree_id')->notNull();
            $table->integer('account_id')->unique()->notNull();
            $table->integer('salary_id')->unique()->notNull();

            $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
            $table->foreign('salary_id')->references('id')->on('salaries')->cascadeOnDelete();
        });

        Schema::create('administrators', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('full_name', 255)->notNull();
            $table->integer('account_id')->unique()->notNull();
            $table->integer('report_id')->notNull();

            $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
        });

        Schema::create('warehouse_staff', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('full_name', 255)->notNull();
        });
    }

    public function down(): void {
        Schema::dropIfExists('warehouse_staff');
        Schema::dropIfExists('administrators');
        Schema::dropIfExists('pharmacists');
        Schema::dropIfExists('salaries');
    }
};
