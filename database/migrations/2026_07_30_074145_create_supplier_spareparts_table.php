<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_spareparts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('supplier_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sparepart_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('harga_beli', 15, 2);

            $table->timestamps();

            $table->unique(['supplier_id', 'sparepart_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_spareparts');
    }
};