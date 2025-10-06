<?php

declare(strict_types=1);

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('address_id')->constrained('addresses');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->decimal('delivery_price', 19, 0)->default(0);
            $table->decimal('coupon_price', 19, 0)->default(0);
            $table->decimal('total_price', 19, 0);
            $table->smallInteger('payment_type')->default(0); // ['online','pos','credit']
            $table->foreignId('payment_id')->nullable()->constrained('payments');
            $table->longText('desc')->nullable();
            $table->string('tracking_code')->nullable();
            $table->foreignId('send_type_id')->nullable()->constrained('send_types');
            $table->foreignId('pay_type_id')->nullable()->constrained('pay_types');

            $table->foreignId('created_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('orders');
    }
};
