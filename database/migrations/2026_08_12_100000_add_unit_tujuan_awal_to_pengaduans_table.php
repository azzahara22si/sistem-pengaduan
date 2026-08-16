<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('unit_tujuan_awal')->nullable()->after('unit_tujuan');
        });

        DB::table('pengaduans')->orderBy('id')->each(function ($pengaduan) {
            $unitTujuanAwal = DB::table('penyaluran_pengaduans')
                ->where('pengaduan_id', $pengaduan->id)
                ->orderBy('created_at')
                ->value('from_unit_tujuan') ?: $pengaduan->unit_tujuan;

            DB::table('pengaduans')
                ->where('id', $pengaduan->id)
                ->update(['unit_tujuan_awal' => $unitTujuanAwal]);
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn('unit_tujuan_awal');
        });
    }
};
