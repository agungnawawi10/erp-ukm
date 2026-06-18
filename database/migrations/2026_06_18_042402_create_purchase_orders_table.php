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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // Nomor PO, unik
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Foreign key ke tabel suppliers
            $table->date('order_date'); // Tanggal order
            $table->string('status')->default('draft'); // Status (contoh default: draf)
            $table->text('notes')->nullable(); // Notes (bisa dikosongkan/nullable)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // User yg membuat PO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
