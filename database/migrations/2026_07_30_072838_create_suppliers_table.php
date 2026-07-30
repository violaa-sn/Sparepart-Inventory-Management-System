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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier', 100)->unique();
            $table->string('nama_supplier', 150);
            $table->text('alamat');
            $table->string('notlp');
            $table->string('email')->unique();
            $table->enum('status_supplier', ['aktif', 'nonaktif'])
                ->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
