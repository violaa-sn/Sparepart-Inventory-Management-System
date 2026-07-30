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
        Schema::create('stok_transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_transaksi_id')->constrained();
            $table->foreignId('sparepart_id')->constrained();
            $table->unsignedInteger('qty');
            $table->decimal('harga_perunit', 15,2)->nullable();
            $table->timestamps();
            $table->unique(['stok_transaksi_id', 'sparepart_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_transaksi_details');
    }
};
