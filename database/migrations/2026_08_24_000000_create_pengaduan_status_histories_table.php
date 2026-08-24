<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_status_histories');
    }
};
