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
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->enum('type', ['fixed', 'percentage', 'free_shipping'])->default('fixed');
            $table->decimal('value', 10, 2); // e.g. 500.00 (Fixed) or 20.00 (Percentage)
            $table->decimal('max_discount_amount', 10, 2)->nullable();

            $table->decimal('min_order_amount', 10, 2)->default(0.00); // min order amount for appling coupon

            // 4. Usage Limits
            $table->unsignedInteger('usage_limit_total')->nullable(); // total uses count
            $table->unsignedInteger('usage_limit_per_user')->default(1); 
            $table->unsignedInteger('total_uses')->default(0);

            // 5. Validity & Status
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('short_order')->default(0); 

            $table->timestamps();

            $table->index(['code', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_codes');
    }
};
