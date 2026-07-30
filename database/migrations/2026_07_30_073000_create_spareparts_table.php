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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sparepart', 100)->unique();
            $table->string('nama_sparepart', 100);
            $table->foreignId('kategori_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('brand_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('unit_id')
                ->constrained()
                ->restrictOnDelete();
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('min_stok');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};
