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
        Schema::create('stok_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 100)->unique();
            $table->foreignId('user_id')
                ->constrained();
            $table->foreignId('supplier_id')->nullable()
                ->constrained();
            $table->enum('tipe', ['in', 'out']);
            $table->dateTime('tanggal_transaksi');
            $table->enum('status_transaksi', ['selesai', 'dibatalkan'])
                ->default('selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_transaksis');
    }
};
