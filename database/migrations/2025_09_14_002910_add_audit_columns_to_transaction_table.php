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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('prev_stock')->nullable()->after('quantity');
            $table->integer('new_stock')->nullable()->after('prev_stock');
            $table->text('note')->nullable()->after('new_stock');

            $table->index('product_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['product_id',]);
            $table->dropIndex(['created_by',]);
            $table->dropColumn(['prev_stock', 'new_stock', 'note']);
        });
    }
};
