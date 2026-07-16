<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default('approved')->after('is_active');
            $table->foreignId('submitted_by')->nullable()->after('status')->constrained('users');
        });

        DB::table('products')->update(['status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropColumn(['status', 'submitted_by']);
        });
    }
};
