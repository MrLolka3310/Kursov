<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('warehouse_cell_id')->constrained('warehouse_cells')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['INCOMING', 'OUTGOING', 'TRANSFER', 'CORRECTION']);
            $table->decimal('quantity', 10, 3);
            $table->string('document_type', 50)->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            
            $table->index(['document_type', 'document_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};