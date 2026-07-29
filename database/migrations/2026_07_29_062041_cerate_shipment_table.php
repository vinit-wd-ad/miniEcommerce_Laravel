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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Logistics & Tracking Info
            $table->string('tracking_number')->nullable()->unique(); // e.g. "AWB987654321"
            $table->string('courier_name')->nullable(); // e.g. "Delhivery", "BlueDart", "Shiprocket"
            $table->string('tracking_url')->nullable(); // Live tracking link

            // Shipment Status Timeline
            $table->enum('status', [
                'pending',
                'processing',
                'shipped',
                'out_for_delivery',
                'delivered',
                'failed',
                'returned'
            ])->default('pending');

            // Timestamps for Tracking Stages
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('estimated_delivery_at')->nullable();
            $table->dateTime('delivered_at')->nullable();

            $table->text('notes')->nullable(); 
            $table->integer('short_order')->default(0);
            $table->timestamps();

            // Performance Indexing
            $table->index(['order_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
