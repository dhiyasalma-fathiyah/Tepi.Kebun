<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();

            $table->string('product_name', 100);
            $table->string('slug', 120)->unique();
            $table->enum('grade', ['A', 'B']);
            $table->unsignedTinyInteger('ripeness_percentage');

            $table->decimal('weight_per_box', 8, 2);
            $table->decimal('price_per_box', 12, 2);
            $table->unsignedInteger('stock')->default(0);

            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
