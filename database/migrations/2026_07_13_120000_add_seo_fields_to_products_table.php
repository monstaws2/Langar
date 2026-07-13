<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds lightweight, optional SEO fields to the products table so store
     * owners can fill them in later. Every column is nullable — a product
     * with no SEO data still works fine because the Product model provides
     * sensible fallbacks (see Product::seoTitle(), seoMetaDescription(), etc).
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'meta_title')) {
                $table->string('meta_title', 70)->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'meta_description')) {
                $table->string('meta_description', 320)->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('products', 'seo_tags')) {
                $table->text('seo_tags')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('products', 'canonical_url')) {
                $table->string('canonical_url', 255)->nullable()->after('seo_tags');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['meta_title', 'meta_description', 'seo_tags', 'canonical_url'] as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
