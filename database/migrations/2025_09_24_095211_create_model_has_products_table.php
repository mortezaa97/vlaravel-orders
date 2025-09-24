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
        Schema::create('model_has_products', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->decimal('price', 19, 0);
            $table->smallInteger('count')->default(1);
            $table->longText('desc')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_products');
    }
};
