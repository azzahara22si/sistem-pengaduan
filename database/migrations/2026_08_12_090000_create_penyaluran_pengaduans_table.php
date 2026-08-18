<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penyaluran_pengaduans')) {
            Schema::create('penyaluran_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_unit_id')->nullable()->constrained('unit_layanans')->nullOnDelete();
            $table->string('from_unit_tujuan')->nullable();
            $table->foreignId('to_unit_id')->nullable()->constrained('unit_layanans')->nullOnDelete();
            $table->string('to_unit_tujuan');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('penyaluran_pengaduans');
    }
};
