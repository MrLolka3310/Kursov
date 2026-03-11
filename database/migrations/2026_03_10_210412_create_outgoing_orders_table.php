<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('order_date');
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('warehouse_cell_id')->constrained('warehouse_cells')->onDelete('restrict');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', ['draft', 'reserved', 'shipped', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_orders');
    }
};