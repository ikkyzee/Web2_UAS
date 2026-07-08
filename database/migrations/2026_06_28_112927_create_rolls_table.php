<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penerimaan_id')->constrained('penerimaans')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->string('nomor_roll')->unique();
            $table->decimal('berat_kg', 10, 2);
            $table->enum('status', ['di_gudang', 'dikirim'])->default('di_gudang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolls');
    }
};
