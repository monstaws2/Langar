<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOTE: This migration is a no-op because the `order_items` table is already
// created inside 2026_07_03_101500_create_orders_table.php.  We keep the file
// so that the migration history stays intact on existing installs.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('order_items')) {
            return;
        }

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('total_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Intentionally empty — the paired migration owns this table.
    }
};
