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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('kontak');
            $table->string('kontak_person')->nullable()->after('nama_supplier');
            $table->string('no_telepon', 50)->nullable()->after('kontak_person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['kontak_person', 'no_telepon']);
            $table->string('kontak')->nullable();
        });
    }
};
