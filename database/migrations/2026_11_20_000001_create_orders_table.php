<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 24)->unique();

            $table->string('customer_name', 100);
            $table->string('phone', 20);
            $table->string('email')->nullable();

            $table->text('address');
            $table->string('city', 100);
            $table->string('postal_code', 10);
            $table->text('notes')->nullable();

            $table->string('payment_method', 20)->default('transfer');
            $table->string('status', 20)->default('pending')->index();
            $table->decimal('total_amount', 14, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot nama & harga supaya riwayat pesanan tidak berubah saat produk diedit.
            $table->string('product_name', 100);
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 14, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
