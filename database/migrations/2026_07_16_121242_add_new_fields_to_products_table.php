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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_per_day', 8, 2)->nullable()->after('description');
            $table->string('size')->nullable()->after('price_per_day');
            $table->string('color')->nullable()->after('size');
            $table->string('category')->nullable()->after('color');
            $table->json('images')->nullable()->after('featured_image');
            $table->json('availability')->nullable()->after('images');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_per_day', 'size', 'color', 'category', 'images', 'availability']);
        });
    }
};
