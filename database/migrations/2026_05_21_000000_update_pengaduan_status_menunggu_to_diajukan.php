<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pengaduans')
            ->where('status', 'menunggu')
            ->update(['status' => 'diajukan']);
    }

    public function down(): void
    {
        DB::table('pengaduans')
            ->where('status', 'diajukan')
            ->update(['status' => 'menunggu']);
    }
};
