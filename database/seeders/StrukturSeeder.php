<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Struktur;

class StrukturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Struktur::truncate();

        // Template data untuk setiap jabatan dengan 3 anggota
        $jabatanTemplates = [
            'Kepala Dinas' => [
                ['nama' => 'Dr. Ir. CHRISTIAN RAIN, MT', 'nip' => '196808131995031004', 'golongan' => 'IV/c'],
                ['nama' => 'Ir. MUHAMMAD SALEH, MT', 'nip' => '197201152000031002', 'golongan' => 'IV/c'],
                ['nama' => 'Dr. BAMBANG SUTRISNO, MT', 'nip' => '196905201994031001', 'golongan' => 'IV/c']
            ],
            'Sekretaris' => [
                ['nama' => 'Ir. BUDI SETIAWAN, MT', 'nip' => '197305152000031008', 'golongan' => 'IV/b'],
                ['nama' => 'DEWI LESTARI, S.AP, M.AP', 'nip' => '198103252006032001', 'golongan' => 'IV/a'],
                ['nama' => 'AHMAD RIFAI, S.IP, M.Si', 'nip' => '197912081005031003', 'golongan' => 'IV/a']
            ],
            'Kepala Subbagian Umum dan Kepegawaian' => [
                ['nama' => 'SITI RAHAYU, S.Sos', 'nip' => '198012251005032001', 'golongan' => 'III/c'],
                ['nama' => 'RATNA SARI, S.AP', 'nip' => '198506112010032002', 'golongan' => 'III/c'],
                ['nama' => 'FITRI HANDAYANI, S.Sos', 'nip' => '198904152012032001', 'golongan' => 'III/b']
            ],
            'Kepala Subbagian Keuangan, Perencanaan, Evaluasi dan Pelaporan' => [
                ['nama' => 'AHMAD FAUZI, SE', 'nip' => '198506151010031003', 'golongan' => 'III/d'],
                ['nama' => 'MAYA SARI, SE, M.Ak', 'nip' => '198801202011032001', 'golongan' => 'III/c'],
                ['nama' => 'RUDI HARTONO, SE', 'nip' => '198703142013031002', 'golongan' => 'III/c']
            ],
            'Kepala Bidang Bina Marga' => [
                ['nama' => 'Ir. HENDRA WIJAYA, MT', 'nip' => '197701102005031001', 'golongan' => 'IV/a'],
                ['nama' => 'WAHYU SETIADI, ST, MT', 'nip' => '198205182008031004', 'golongan' => 'IV/a'],
                ['nama' => 'EKO PRASETYO, ST', 'nip' => '198409122010031003', 'golongan' => 'III/d']
            ],
            'Kepala Seksi Pembangunan Jalan dan Jembatan' => [
                ['nama' => 'PUTRA PERDANA, ST', 'nip' => '198803152014031002', 'golongan' => 'III/c'],
                ['nama' => 'ANDI KURNIAWAN, ST', 'nip' => '198906282015031001', 'golongan' => 'III/c'],
                ['nama' => 'FERRY HERMAWAN, ST', 'nip' => '199001152016031002', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Pemeliharaan Jalan dan Jembatan' => [
                ['nama' => 'RIZKI PRATAMA, ST', 'nip' => '199001081015031001', 'golongan' => 'III/c'],
                ['nama' => 'DEDI KURNIAWAN, ST', 'nip' => '198912232014031001', 'golongan' => 'III/c'],
                ['nama' => 'AGUS SETIAWAN, ST', 'nip' => '199105142016031003', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Perencanaan Teknik Jalan dan Jembatan' => [
                ['nama' => 'DEDI KURNIAWAN, ST', 'nip' => '198912232014031001', 'golongan' => 'III/c'],
                ['nama' => 'BUDI SANTOSO, ST', 'nip' => '199002182015031002', 'golongan' => 'III/c'],
                ['nama' => 'INDRA WIJAYA, ST', 'nip' => '199108252016031001', 'golongan' => 'III/b']
            ],
            'Kepala Bidang Cipta Karya' => [
                ['nama' => 'Ir. DEWI SARTIKA, MT', 'nip' => '197808202006032002', 'golongan' => 'IV/a'],
                ['nama' => 'MAYA SARI, ST, MT', 'nip' => '198203252008032001', 'golongan' => 'IV/a'],
                ['nama' => 'LINDA PERMATA, ST', 'nip' => '198506122010032003', 'golongan' => 'III/d']
            ],
            'Kepala Seksi Perumahan dan Permukiman' => [
                ['nama' => 'INDRA CAHYADI, ST', 'nip' => '198705112014031003', 'golongan' => 'III/c'],
                ['nama' => 'NOVA ANDRIANI, ST', 'nip' => '199104252016032003', 'golongan' => 'III/c'],
                ['nama' => 'SARAH WIJAYANTI, ST', 'nip' => '199203142017032001', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Bangunan Gedung' => [
                ['nama' => 'MAYA SARI, ST', 'nip' => '199203142016032001', 'golongan' => 'III/c'],
                ['nama' => 'ARIEF RAHMAN, ST', 'nip' => '198810051015031002', 'golongan' => 'III/c'],
                ['nama' => 'FITRI HANDAYANI, ST', 'nip' => '199006082017032002', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Penyehatan Lingkungan Permukiman' => [
                ['nama' => 'ARIEF RAHMAN, ST', 'nip' => '198810051015031002', 'golongan' => 'III/c'],
                ['nama' => 'WAHYU HIDAYAT, ST', 'nip' => '198709112015031001', 'golongan' => 'III/c'],
                ['nama' => 'RATNA DEWI, ST', 'nip' => '199104182016032004', 'golongan' => 'III/b']
            ],
            'Kepala Bidang Tata Ruang dan Bina Konstruksi' => [
                ['nama' => 'Ir. BAMBANG SURYANTO, MT', 'nip' => '197606152005031002', 'golongan' => 'IV/a'],
                ['nama' => 'TEGUH PRASETYO, ST, MT', 'nip' => '198108222008031003', 'golongan' => 'IV/a'],
                ['nama' => 'HENDRA WIJAYA, ST', 'nip' => '198407152010031004', 'golongan' => 'III/d']
            ],
            'Kepala Seksi Penataan Ruang' => [
                ['nama' => 'FITRI HANDAYANI, ST', 'nip' => '199006082016032002', 'golongan' => 'III/c'],
                ['nama' => 'NOVA ANDRIANI, ST', 'nip' => '199104252016032003', 'golongan' => 'III/c'],
                ['nama' => 'SARI DEWI, ST', 'nip' => '199205152017032001', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Pengendalian Pemanfaatan Ruang' => [
                ['nama' => 'WAHYU HIDAYAT, ST', 'nip' => '198709112015031001', 'golongan' => 'III/c'],
                ['nama' => 'ANDI SETIAWAN, ST', 'nip' => '198608192014031004', 'golongan' => 'III/c'],
                ['nama' => 'PUTRA PRATAMA, ST', 'nip' => '199103182016031005', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Bina Konstruksi' => [
                ['nama' => 'NOVA ANDRIANI, ST', 'nip' => '199104252016032003', 'golongan' => 'III/c'],
                ['nama' => 'FERRY HERMAWAN, ST', 'nip' => '198911032015031002', 'golongan' => 'III/c'],
                ['nama' => 'BAYU SANTOSO, ST', 'nip' => '199208142017031001', 'golongan' => 'III/b']
            ],
            'Kepala Bidang Sumber Daya Air' => [
                ['nama' => 'Ir. TEGUH PRASETYO, MT', 'nip' => '197904142006031001', 'golongan' => 'IV/a'],
                ['nama' => 'BAMBANG SUTRISNO, ST, MT', 'nip' => '198006182008031002', 'golongan' => 'IV/a'],
                ['nama' => 'RUDI HARTANTO, ST', 'nip' => '198505122010031005', 'golongan' => 'III/d']
            ],
            'Kepala Seksi Irigasi dan Rawa' => [
                ['nama' => 'ANDI SETIAWAN, ST', 'nip' => '198608192014031004', 'golongan' => 'III/c'],
                ['nama' => 'RATNA SARI, ST', 'nip' => '199207152016032004', 'golongan' => 'III/c'],
                ['nama' => 'INDRA PRASETYO, ST', 'nip' => '199106252017031002', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Sungai, Pantai dan Drainase' => [
                ['nama' => 'RATNA SARI, ST', 'nip' => '199207152016032004', 'golongan' => 'III/c'],
                ['nama' => 'FERRY HERMAWAN, ST', 'nip' => '198911032015031002', 'golongan' => 'III/c'],
                ['nama' => 'DEWI LESTARI, ST', 'nip' => '199304182017032003', 'golongan' => 'III/b']
            ],
            'Kepala Seksi Bina Operasi dan Pemeliharaan' => [
                ['nama' => 'FERRY HERMAWAN, ST', 'nip' => '198911032015031002', 'golongan' => 'III/c'],
                ['nama' => 'BAYU SANTOSO, ST', 'nip' => '199308142019031001', 'golongan' => 'III/c'],
                ['nama' => 'AHMAD FAUZI, ST', 'nip' => '199407152017031003', 'golongan' => 'III/b']
            ],
            'Staff IT dan Sistem Informasi' => [
                ['nama' => 'SARAH WIJAYANTI, S.Kom', 'nip' => '199505102018032001', 'golongan' => 'III/a'],
                ['nama' => 'BAYU SANTOSO, S.Kom', 'nip' => '199608142019031002', 'golongan' => 'III/a'],
                ['nama' => 'LINDA PERMATASARI, S.Kom', 'nip' => '199712182020032001', 'golongan' => 'II/d']
            ],
            'Staff Administrasi' => [
                ['nama' => 'BAYU SANTOSO, A.Md', 'nip' => '199308142019031001', 'golongan' => 'II/c'],
                ['nama' => 'SITI NURHALIZA, A.Md', 'nip' => '199509182020032002', 'golongan' => 'II/c'],
                ['nama' => 'ANDI PRATAMA, A.Md', 'nip' => '199610142019031003', 'golongan' => 'II/c']
            ],
            'Staff Keuangan' => [
                ['nama' => 'LINDA PERMATASARI, SE', 'nip' => '199612182018032002', 'golongan' => 'II/d'],
                ['nama' => 'MAYA SARI, SE', 'nip' => '199703252019032001', 'golongan' => 'II/d'],
                ['nama' => 'RUDI SETIAWAN, SE', 'nip' => '199805142020031001', 'golongan' => 'II/c']
            ]
        ];

        $urutan = 1;
        foreach ($jabatanTemplates as $jabatan => $members) {
            foreach ($members as $index => $member) {
                $posisi = $index + 1;
                $emailPrefix = strtolower(str_replace([' ', ',', 'dan'], ['', '', ''], $jabatan));

                Struktur::create([
                    'nama' => $member['nama'],
                    'jabatan' => $jabatan,
                    'nip' => $member['nip'],
                    'golongan' => $member['golongan'],
                    'unit_kerja' => 'Dinas PUPR',
                    'email' => $emailPrefix . $posisi . '@pupr-katingan.go.id',
                    'telepon' => '0536-' . (21230 + $urutan),
                    'alamat' => 'Jl. Alamat No. ' . $urutan . ', Kasongan',
                    'urutan' => $urutan,
                    'status' => 'aktif',
                    'keterangan' => $jabatan . ' - Anggota ' . $posisi
                ]);

                $urutan++;
            }
        }
    }
}
