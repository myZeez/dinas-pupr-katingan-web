<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturFreshSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('struktur')->truncate();

        $strukturData = [
            [
                'nama' => 'Dr. Ahmad Yulhendri',
                'jabatan' => 'Kepala Dinas',
                'nip' => '19650308 198703 1 004',
                'golongan' => 'IV/d',
                'unit_kerja' => 'Dinas PUPR',
                'urutan' => 1,
                'status' => 'aktif',
                'keterangan' => 'Memimpin dan mengelola seluruh kegiatan Dinas PUPR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Budi Santoso, MT',
                'jabatan' => 'Sekretaris Dinas',
                'nip' => '19680415 199203 1 003',
                'golongan' => 'IV/c',
                'unit_kerja' => 'Sekretariat',
                'urutan' => 2,
                'status' => 'aktif',
                'keterangan' => 'Mengelola administrasi, keuangan, dan kepegawaian dinas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Drs. Suryadi',
                'jabatan' => 'Kepala Sub Bagian Umum',
                'nip' => '19700520 199803 1 002',
                'golongan' => 'III/d',
                'unit_kerja' => 'Sub Bagian Umum & Kepegawaian',
                'urutan' => 3,
                'status' => 'aktif',
                'keterangan' => 'Mengelola administrasi umum dan kepegawaian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Siti Nurhaliza, SE',
                'jabatan' => 'Kepala Sub Bagian Keuangan',
                'nip' => '19720610 199603 2 001',
                'golongan' => 'III/d',
                'unit_kerja' => 'Sub Bagian Keuangan',
                'urutan' => 4,
                'status' => 'aktif',
                'keterangan' => 'Mengelola keuangan dan anggaran dinas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Drs. Bambang Widodo, M.Si',
                'jabatan' => 'Kepala Sub Bagian Program',
                'nip' => '19690725 199503 1 005',
                'golongan' => 'III/d',
                'unit_kerja' => 'Sub Bagian Perencanaan / Program',
                'urutan' => 5,
                'status' => 'aktif',
                'keterangan' => 'Mengelola perencanaan program dan kegiatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Hendro Prasetyo, MT',
                'jabatan' => 'Kepala Bidang Bina Marga',
                'nip' => '19741012 199903 1 001',
                'golongan' => 'IV/b',
                'unit_kerja' => 'Bidang Bina Marga',
                'urutan' => 6,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pembangunan dan pemeliharaan jalan serta jembatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Agus Firmansyah, ST',
                'jabatan' => 'Kepala Seksi Jalan',
                'nip' => '19760318 200003 1 002',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Jalan',
                'urutan' => 7,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pembangunan dan pemeliharaan jalan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Rina Kartika, MT',
                'jabatan' => 'Kepala Seksi Jembatan',
                'nip' => '19780422 200203 2 001',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Jembatan',
                'urutan' => 8,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pembangunan dan pemeliharaan jembatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dr. Ir. Widya Sari, MT',
                'jabatan' => 'Kepala Bidang Cipta Karya',
                'nip' => '19730205 199803 2 003',
                'golongan' => 'IV/b',
                'unit_kerja' => 'Bidang Cipta Karya',
                'urutan' => 9,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pembangunan perumahan, air minum, dan sanitasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Drs. Hadi Suroso',
                'jabatan' => 'Kepala Seksi Perumahan',
                'nip' => '19751128 199903 1 004',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Perumahan',
                'urutan' => 10,
                'status' => 'aktif',
                'keterangan' => 'Mengelola program perumahan dan permukiman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Dewi Lestari, ST',
                'jabatan' => 'Kepala Seksi Air Minum',
                'nip' => '19770806 200103 2 002',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Air Minum',
                'urutan' => 11,
                'status' => 'aktif',
                'keterangan' => 'Mengelola sistem penyediaan air minum',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ahmad Ridwan, ST, MT',
                'jabatan' => 'Kepala Seksi Sanitasi',
                'nip' => '19790914 200403 1 001',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Sanitasi',
                'urutan' => 12,
                'status' => 'aktif',
                'keterangan' => 'Mengelola sistem sanitasi dan persampahan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dr. Ir. Rudi Hartono, M.Plan',
                'jabatan' => 'Kepala Bidang Penataan Ruang',
                'nip' => '19720330 199603 1 002',
                'golongan' => 'IV/b',
                'unit_kerja' => 'Bidang Penataan Ruang',
                'urutan' => 13,
                'status' => 'aktif',
                'keterangan' => 'Mengelola perencanaan dan pengendalian tata ruang wilayah',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Siska Wulandari, MT',
                'jabatan' => 'Kepala Seksi Perencanaan',
                'nip' => '19810507 200603 2 001',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Perencanaan Tata Ruang',
                'urutan' => 14,
                'status' => 'aktif',
                'keterangan' => 'Mengelola perencanaan tata ruang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Drs. Taufik Hidayat, M.Si',
                'jabatan' => 'Kepala Seksi Pengendalian',
                'nip' => '19741218 199903 1 003',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Pengendalian Pemanfaatan Ruang',
                'urutan' => 15,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pengendalian pemanfaatan ruang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Yusuf Rahman, MT',
                'jabatan' => 'Kepala Bidang Sumber Daya Air',
                'nip' => '19690923 199403 1 001',
                'golongan' => 'IV/b',
                'unit_kerja' => 'Bidang Sumber Daya Air',
                'urutan' => 16,
                'status' => 'aktif',
                'keterangan' => 'Mengelola irigasi, sungai, dan sumber daya air',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ir. Nova Andriani, ST',
                'jabatan' => 'Kepala Seksi Irigasi',
                'nip' => '19820815 200803 2 002',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Irigasi',
                'urutan' => 17,
                'status' => 'aktif',
                'keterangan' => 'Mengelola sistem irigasi pertanian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Drs. Maryono',
                'jabatan' => 'Kepala Seksi Sungai',
                'nip' => '19761101 200003 1 004',
                'golongan' => 'III/c',
                'unit_kerja' => 'Seksi Sungai',
                'urutan' => 18,
                'status' => 'aktif',
                'keterangan' => 'Mengelola pengendalian sungai dan drainase',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dr. Ir. Andi Wijaya, MT',
                'jabatan' => 'Staff Ahli',
                'nip' => '19701205 199503 1 002',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Dinas PUPR',
                'urutan' => 19,
                'status' => 'aktif',
                'keterangan' => 'Memberikan masukan teknis dan profesional',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Sari Indrawati, S.Kom',
                'jabatan' => 'Staff',
                'nip' => '19850612 200903 2 001',
                'golongan' => 'III/a',
                'unit_kerja' => 'Dinas PUPR',
                'urutan' => 20,
                'status' => 'aktif',
                'keterangan' => 'Melaksanakan tugas-tugas operasional dan administrasi',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($strukturData as $data) {
            DB::table('struktur')->insert($data);
        }
    }
}
