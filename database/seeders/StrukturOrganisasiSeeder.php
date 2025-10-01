<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Struktur;

class StrukturOrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        Struktur::truncate();

        $strukturData = [
            // KEPALA DINAS
            [
                'nama' => 'Dr. Ir. CHRISTIAN RAIN, MT',
                'jabatan' => 'KEPALA DINAS',
                'nip' => '19681308 199503 1 004',
                'golongan' => 'PEMBINA UTAMA MUDA/IV.c',
                'unit_kerja' => 'pimpinan',
                'urutan' => 1,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // SEKRETARIS
            [
                'nama' => 'DEWI UNTARI, ST., MT',
                'jabatan' => 'SEKRETARIS',
                'nip' => '19711212 199703 2 006',
                'golongan' => 'Pembina Tk. I/ IV.b',
                'unit_kerja' => 'sekretariat',
                'urutan' => 2,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KELOMPOK JABATAN FUNGSIONAL (di bawah Kepala Dinas)
            [
                'nama' => 'KELOMPOK JABATAN FUNGSIONAL',
                'jabatan' => 'KELOMPOK JABATAN FUNGSIONAL',
                'nip' => '-',
                'golongan' => '-',
                'unit_kerja' => 'pimpinan',
                'urutan' => 3,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN
            [
                'nama' => 'EVATRIANEKA JUNANDA, ST',
                'jabatan' => 'KEPALA SUB BAGIAN UMUM DAN KEPEGAWAIAN',
                'nip' => '19740316 201406 1 002',
                'golongan' => 'PENATA Tk. I /III. d',
                'unit_kerja' => 'sekretariat',
                'urutan' => 4,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KEPALA SUB BAGIAN KEUANGAN, PERENCANAAN, EVALUASI DAN PELAPORAN
            [
                'nama' => 'RENDY MONTE SIGARA, ST',
                'jabatan' => 'KEPALA SUB BAGIAN KEUANGAN, PERENCANAAN, EVALUASI DAN PELAPORAN',
                'nip' => '19860803 201001 1 004',
                'golongan' => 'PENATA Tk. I/ III.d',
                'unit_kerja' => 'sekretariat',
                'urutan' => 5,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KEPALA BIDANG CIPTA KARYA
            [
                'nama' => 'HESRON, ST., MT',
                'jabatan' => 'KEPALA BIDANG CIPTA KARYA',
                'nip' => '19800108 201503 1 003',
                'golongan' => 'Penata Tk. I /III.d',
                'unit_kerja' => 'cipta_karya',
                'urutan' => 6,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KEPALA BIDANG SUMBER DAYA AIR
            [
                'nama' => 'FRANCO CHRISTALINO, ST., M.Si',
                'jabatan' => 'KEPALA BIDANG SUMBER DAYA AIR',
                'nip' => '19770528 199803 1 005',
                'golongan' => 'Penata Tk. I/III.d',
                'unit_kerja' => 'sumber_daya_air',
                'urutan' => 7,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // KEPALA BIDANG BINA MARGA
            [
                'nama' => 'FILADO, S.T.',
                'jabatan' => 'KEPALA BIDANG BINA MARGA',
                'nip' => '19780908 201001 1 006',
                'golongan' => 'Penata Tk. I/III.d',
                'unit_kerja' => 'bina_marga',
                'urutan' => 8,
                'status' => 'aktif',
                'memerlukan_plt' => false
            ],

            // PLT. KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI
            [
                'nama' => 'BENONG SUPRIADI, S.T.',
                'jabatan' => 'PLT. KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI',
                'nip' => '19780829 201001 1 007',
                'golongan' => 'Penata Tingkat I /III.d',
                'unit_kerja' => 'tata_ruang',
                'urutan' => 9,
                'status' => 'aktif',
                'memerlukan_plt' => true,
                'plt_status' => 'aktif',
                'plt_nama_manual' => 'BENONG SUPRIADI, S.T.',
                'plt_jabatan_manual' => 'PLT. KEPALA BIDANG TATA RUANG DAN BINA KONSTRUKSI',
                'plt_keterangan' => 'Pelaksana Tugas Kepala Bidang'
            ],
        ];

        foreach ($strukturData as $data) {
            Struktur::create($data);
        }

        $this->command->info('Struktur organisasi berhasil diimport!');
        $this->command->info('Total data: ' . count($strukturData) . ' records');
    }
}
