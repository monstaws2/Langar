<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop old tables first (if they exist) to recreate with correct schema
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');

        // Create orders table with correct schema
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code', 20)->nullable();
            $table->unsignedBigInteger('total_price')->default(0);
            $table->enum('status', ['pending', 'paid', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
