<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Struktur;

class UpdateUnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update unit_kerja based on jabatan
        $mappings = [
            'Kepala Dinas' => 'Dinas PUPR',
            'Sekretaris Dinas' => 'Sekretariat',

            // Sub Bagian
            'Kepala Sub Bagian Umum' => 'Sub Bagian Umum & Kepegawaian',
            'Kepala Sub Bagian Keuangan' => 'Sub Bagian Keuangan',
            'Kepala Sub Bagian Program' => 'Sub Bagian Perencanaan / Program',

            // Bidang Bina Marga
            'Kepala Bidang Bina Marga' => 'Bidang Bina Marga',
            'Kepala Seksi Jalan' => 'Seksi Jalan',
            'Kepala Seksi Jembatan' => 'Seksi Jembatan',

            // Bidang Cipta Karya
            'Kepala Bidang Cipta Karya' => 'Bidang Cipta Karya',
            'Kepala Seksi Perumahan' => 'Seksi Perumahan',
            'Kepala Seksi Air Minum' => 'Seksi Air Minum',
            'Kepala Seksi Sanitasi' => 'Seksi Sanitasi',

            // Bidang Penataan Ruang
            'Kepala Bidang Penataan Ruang' => 'Bidang Penataan Ruang',
            'Kepala Seksi Perencanaan Tata Ruang' => 'Seksi Perencanaan Tata Ruang',
            'Kepala Seksi Pengendalian Pemanfaatan Ruang' => 'Seksi Pengendalian Pemanfaatan Ruang',

            // Bidang SDA
            'Kepala Bidang Sumber Daya Air' => 'Bidang Sumber Daya Air',
            'Kepala Seksi Irigasi' => 'Seksi Irigasi',
            'Kepala Seksi Sungai' => 'Seksi Sungai',

            // Staff Ahli
            'Staff Ahli' => 'Dinas PUPR',
        ];

        foreach ($mappings as $jabatan => $unitKerja) {
            Struktur::where('jabatan', $jabatan)->update(['unit_kerja' => $unitKerja]);
        }

        $this->command->info('Unit kerja berhasil diperbarui berdasarkan jabatan!');
    }
}
