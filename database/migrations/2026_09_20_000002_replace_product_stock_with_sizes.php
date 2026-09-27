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
            $table->json('sizes')->nullable()->after('color');
        });

        DB::table('products')->select('id', 'size', 'stock')->get()->each(function (object $product): void {
            $sizes = $product->size !== null && $product->size !== ''
                ? [$product->size => max(0, (int) $product->stock)]
                : [];

            DB::table('products')->where('id', $product->id)->update([
                'sizes' => json_encode($sizes),
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['size', 'stock']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('size')->nullable()->after('product_id');
        });

        DB::table('cart_items')->whereNull('size')->delete();

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id']);
            $table->unique(['user_id', 'product_id', 'size']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('size')->nullable()->after('color');
            $table->integer('stock')->default(0)->after('size');
        });

        DB::table('products')->select('id', 'sizes')->get()->each(function (object $product): void {
            $sizes = json_decode($product->sizes ?: '{}', true) ?: [];
            $size = array_key_first($sizes);

            DB::table('products')->where('id', $product->id)->update([
                'size' => $size,
                'stock' => $size === null ? 0 : (int) $sizes[$size],
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sizes');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id', 'size']);
            $table->unique(['user_id', 'product_id']);
            $table->dropColumn('size');
        });
    }
};
