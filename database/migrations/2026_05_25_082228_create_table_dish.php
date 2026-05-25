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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->decimal('vat_rate', 4, 2)->default(10.00);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->integer('display_order')->default(0);
            $table->integer('spicy_level')->default(0); // 0 = no, 1 = poco, 2 = medio, 3 = fuoco
            $table->boolean('is_frozen')->default(false); // Obbligatorio in Italia indicare se il prodotto è surgelato
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
