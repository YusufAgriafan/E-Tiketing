<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // DB::table('users')->insert([
        //     [
        //         'nama' => 'Alfa',
        //         'email' => 'alfa@example.com',
        //         'no_telepon' => '081234567890',
        //         'jumlah_peserta' => 20,
        //         'dewasa' => 10,
        //         'anak' => 10,
        //         'harga' => 150000.00,
        //         'status' => 'belum',
        //         'tanggal_lunas' => now(),
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nama' => 'Beta',
        //         'email' => 'beta@example.com',
        //         'no_telepon' => '089876543210',
        //         'jumlah_peserta' => 30,
        //         'dewasa' => 20,
        //         'anak' => 10,
        //         'harga' => 200000.00,
        //         'status' => 'belum',
        //         'tanggal_lunas' => NULL,
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nama' => 'Charlie',
        //         'email' => 'charlie@example.com',
        //         'no_telepon' => '08843040433',
        //         'jumlah_peserta' => 40,
        //         'dewasa' => 30,
        //         'anak' => 10,
        //         'harga' => 300000.00,
        //         'status' => 'gagal',
        //         'tanggal_lunas' => NULL,
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ]);

        DB::table('kuotas')->insert([
            [
                'peserta' => 'Kloter 1',
                'kuota' => 250,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('admins')->insert([
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
