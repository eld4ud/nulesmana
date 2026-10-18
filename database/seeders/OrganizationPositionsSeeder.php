<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrganizationPositionsSeeder extends Seeder
{
    /**
     * Data CONTOH untuk tampilan struktur awal, BUKAN anggota terverifikasi.
     * Seeder dijalankan manual. Hanya menambahkan JABATAN yang belum ada
     * pada setiap Banom. Data dan perubahan admin tidak ditimpa.
     */
    public function run(): void
    {
        if (!Schema::hasTable('organization_positions')) {
            $this->command?->warn('Tabel organization_positions belum ada. Jalankan migration yang tersedia terlebih dahulu.');
            return;
        }

        $templates = [
            'IPNU' => [
                ['Ketua', 'Contoh Ketua IPNU', 1, 1],
                ['Wakil Ketua', 'Contoh Wakil Ketua IPNU', 2, 1],
                ['Sekretaris', 'Contoh Sekretaris IPNU', 2, 2],
                ['Bendahara', 'Contoh Bendahara IPNU', 2, 3],
                ['Koordinator Kaderisasi', 'Contoh Koordinator IPNU', 3, 1],
            ],
            'IPPNU' => [
                ['Ketua', 'Contoh Ketua IPPNU', 1, 1],
                ['Wakil Ketua', 'Contoh Wakil Ketua IPPNU', 2, 1],
                ['Sekretaris', 'Contoh Sekretaris IPPNU', 2, 2],
                ['Bendahara', 'Contoh Bendahara IPPNU', 2, 3],
                ['Koordinator Kaderisasi', 'Contoh Koordinator IPPNU', 3, 1],
            ],
            'Ansor' => [
                ['Ketua', 'Contoh Ketua Ansor', 1, 1],
                ['Wakil Ketua', 'Contoh Wakil Ketua Ansor', 2, 1],
                ['Sekretaris', 'Contoh Sekretaris Ansor', 2, 2],
                ['Bendahara', 'Contoh Bendahara Ansor', 2, 3],
                ['Koordinator Banser', 'Contoh Koordinator Banser', 3, 1],
            ],
            'Fatayat' => [
                ['Ketua', 'Contoh Ketua Fatayat', 1, 1],
                ['Wakil Ketua', 'Contoh Wakil Ketua Fatayat', 2, 1],
                ['Sekretaris', 'Contoh Sekretaris Fatayat', 2, 2],
                ['Bendahara', 'Contoh Bendahara Fatayat', 2, 3],
                ['Koordinator Program', 'Contoh Koordinator Fatayat', 3, 1],
            ],
            'Muslimat' => [
                ['Ketua', 'Contoh Ketua Muslimat', 1, 1],
                ['Wakil Ketua', 'Contoh Wakil Ketua Muslimat', 2, 1],
                ['Sekretaris', 'Contoh Sekretaris Muslimat', 2, 2],
                ['Bendahara', 'Contoh Bendahara Muslimat', 2, 3],
                ['Koordinator Program', 'Contoh Koordinator Muslimat', 3, 1],
            ],
        ];

        $addedTotal = 0;

        foreach ($templates as $banom => $positions) {
            $now = now();
            $rows = [];

            foreach ($positions as [$role, $personName, $level, $sortOrder]) {
                // Jangan mengganti jabatan yang sudah dibuat atau diedit admin.
                $exists = DB::table('organization_positions')
                    ->where('banom', $banom)
                    ->where('role', $role)
                    ->exists();

                if ($exists) {
                    continue;
                }

                $rows[] = [
                    'banom' => $banom,
                    'role' => $role,
                    'person_name' => $personName,
                    'member_id' => null,
                    'description' => 'Data contoh, belum merupakan penetapan pengurus resmi.',
                    'level' => $level,
                    'sort_order' => $sortOrder,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (!empty($rows)) {
                DB::table('organization_positions')->insert($rows);
            }

            $count = count($rows);
            $addedTotal += $count;
            $this->command?->info("{$banom}: {$count} jabatan contoh baru ditambahkan.");
        }

        $this->command?->info("SELESAI: {$addedTotal} jabatan baru ditambahkan. Data lama tetap aman.");
    }
}
