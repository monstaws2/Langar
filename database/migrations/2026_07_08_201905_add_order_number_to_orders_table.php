<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOTE: order_number is already defined in 2026_07_03_101500_create_orders_table.php.
// This file is kept so the migration history stays intact on existing MySQL installs.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('orders', 'order_number')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('orders', 'order_number')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
};
