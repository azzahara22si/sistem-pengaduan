<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UnitLayanan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $unit = UnitLayanan::firstOrCreate(
            ['email_unit' => 'layanan@example.com'],
            [
                'nama_unit' => 'Unit Layanan Umum',
                'deskripsi_unit' => 'Unit layanan default untuk pengaduan.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin_spmi@example.com'],
            [
                'name' => 'Admin SPMI',
                'password' => Hash::make('password123'),
                'role' => 'admin_spmi',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Unit',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'unit_id' => $unit->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'mahasiswa@example.com'],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
            ]
        );
    }
}
