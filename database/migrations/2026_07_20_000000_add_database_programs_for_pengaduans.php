<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('riwayat_status_pengaduans')) {
            Schema::create('riwayat_status_pengaduans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengaduan_id')->constrained()->cascadeOnDelete();
                $table->string('status_lama');
                $table->string('status_baru');
                $table->timestamp('created_at')->useCurrent();
            });
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_salurkan_pengaduan');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_total_pengaduan_unit');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_riwayat_status_pengaduan');

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_salurkan_pengaduan(
    IN p_pengaduan_id BIGINT,
    IN p_unit_id BIGINT
)
BEGIN
    DECLARE v_nama_unit VARCHAR(255);

    SELECT nama_unit INTO v_nama_unit
    FROM unit_layanans
    WHERE id = p_unit_id;

    IF v_nama_unit IS NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Unit layanan tidak ditemukan';
    END IF;

    UPDATE pengaduans
    SET unit_id = p_unit_id,
        unit_tujuan = v_nama_unit,
        status = 'proses'
    WHERE id = p_pengaduan_id
      AND status = 'diajukan';

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Pengaduan tidak ditemukan atau tidak berstatus diajukan';
    END IF;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE FUNCTION fn_total_pengaduan_unit(p_unit_id BIGINT)
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE total_pengaduan INT;

    SELECT COUNT(*) INTO total_pengaduan
    FROM pengaduans
    WHERE unit_id = p_unit_id;

    RETURN total_pengaduan;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE TRIGGER trg_riwayat_status_pengaduan
AFTER UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    IF OLD.status <> NEW.status THEN
        INSERT INTO riwayat_status_pengaduans (
            pengaduan_id,
            status_lama,
            status_baru,
            created_at
        ) VALUES (
            NEW.id,
            OLD.status,
            NEW.status,
            CURRENT_TIMESTAMP
        );
    END IF;
END
SQL);
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::unprepared('DROP TRIGGER IF EXISTS trg_riwayat_status_pengaduan');
            DB::unprepared('DROP PROCEDURE IF EXISTS sp_salurkan_pengaduan');
            DB::unprepared('DROP FUNCTION IF EXISTS fn_total_pengaduan_unit');
        }

        Schema::dropIfExists('riwayat_status_pengaduans');
    }
};
