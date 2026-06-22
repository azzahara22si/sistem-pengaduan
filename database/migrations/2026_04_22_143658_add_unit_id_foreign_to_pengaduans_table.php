<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        if (!$this->hasForeignKey('pengaduans', 'pengaduans_unit_id_foreign')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->foreign('unit_id')
                    ->references('id')
                    ->on('unit_layanans')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        if ($this->hasForeignKey('pengaduans', 'pengaduans_unit_id_foreign')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->dropForeign('pengaduans_unit_id_foreign');
            });
        }
    }

    private function hasForeignKey(string $table, string $name): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $name)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();
    }
};
