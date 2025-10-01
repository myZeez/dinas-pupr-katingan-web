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

        // Data struktur organisasi berdasarkan gambar yang diberikan
        $jabatanTemplates = [
            'Kepala Dinas' => [
                ['nama' => 'Ir. H. HENDRA, M.T', 'nip' => '196901042000031003', 'golongan' => 'IV/d']
            ],
            'Sekretaris' => [
                ['nama' => 'H. M. TAUFIQURRAHMAN, S.E., M.A.P', 'nip' => '197311062006041005', 'golongan' => 'IV/b']
            ],
            'Kasubbag Umum dan Kepegawaian' => [
                ['nama' => 'MELINA SUSANTI, S.Sos', 'nip' => '198102162006042009', 'golongan' => 'III/d']
            ],
            'Kasubbag Keuangan, Perencanaan, Evaluasi dan Pelaporan' => [
                ['nama' => 'RIYANG PRATAMA, S.E', 'nip' => '198708102010031009', 'golongan' => 'III/d']
            ],
            'Kabid Bina Marga' => [
                ['nama' => 'Ir. H. SUBIYANTO', 'nip' => '196807151996031005', 'golongan' => 'IV/a']
            ],
            'Kasi Pembangunan Jalan' => [
                ['nama' => 'H. AHMAD FAUZI, S.T', 'nip' => '197503262006041011', 'golongan' => 'III/d']
            ],
            'Kasi Pemeliharaan Jalan' => [
                ['nama' => 'SURYANTI, S.T', 'nip' => '197406262008012006', 'golongan' => 'III/d']
            ],
            'Kasi Perencanaan Teknik Jalan' => [
                ['nama' => 'MAULANA SULTAN, S.T', 'nip' => '198407042014061005', 'golongan' => 'III/c']
            ],
            'Kabid Cipta Karya' => [
                ['nama' => 'Ir. H. EDI HERMANSYAH', 'nip' => '196512151991031004', 'golongan' => 'IV/a']
            ],
            'Kasi Perumahan dan Permukiman' => [
                ['nama' => 'RAHMAT HIDAYAT, S.T', 'nip' => '197806192009011010', 'golongan' => 'III/d']
            ],
            'Kasi Bangunan Gedung' => [
                ['nama' => 'FERY ADI GUNAWAN, S.T., M.T', 'nip' => '198402082009041008', 'golongan' => 'III/d']
            ],
            'Kasi Penyehatan Lingkungan Permukiman' => [
                ['nama' => 'KARTIKA SARI, S.T', 'nip' => '197806042008012004', 'golongan' => 'III/d']
            ],
            'Kabid Sumber Daya Air' => [
                ['nama' => 'H. RUDY HIDAYAT, S.T., M.T', 'nip' => '197412172006041006', 'golongan' => 'IV/a']
            ],
            'Kasi Irigasi dan Rawa' => [
                ['nama' => 'BAMBANG HARYONO, S.T', 'nip' => '197203082006041003', 'golongan' => 'III/d']
            ],
            'Kasi Sungai, Pantai dan Drainase' => [
                ['nama' => 'IIN MUNAWAROH, S.T', 'nip' => '198407022014062001', 'golongan' => 'III/c']
            ],
            'Kasi Bina Operasi dan Pemeliharaan' => [
                ['nama' => 'LUKMAN, S.T', 'nip' => '197911282009041001', 'golongan' => 'III/d']
            ],
            'Kabid Bina Konstruksi' => [
                ['nama' => 'H. NURKHOLIS, S.T., M.T', 'nip' => '197106202006041010', 'golongan' => 'IV/a']
            ],
            'Kasi Penataan Bangunan dan Lingkungan' => [
                ['nama' => 'BUDI SETIAWAN, S.T', 'nip' => '198005282014061002', 'golongan' => 'III/c']
            ],
            'Kasi Pengelolaan Jasa Konstruksi' => [
                ['nama' => 'H. YULIANA MERINA SARI, S.T., M.T', 'nip' => '197607052007012002', 'golongan' => 'III/d']
            ],
            'Kasi Tertib Usaha dan Peran Masyarakat' => [
                ['nama' => 'ANA NUR AIDA, S.T., M.T', 'nip' => '198305202014062003', 'golongan' => 'III/c']
            ]
        ];

        $urutan = 1;
        foreach ($jabatanTemplates as $jabatan => $members) {
            foreach ($members as $index => $member) {
                // Tentukan unit_kerja berdasarkan jabatan
                $unit_kerja = 'dinas_pupr';
                if (strpos($jabatan, 'Sekretaris') !== false || strpos($jabatan, 'Kasubbag') !== false) {
                    $unit_kerja = 'sekretariat';
                } elseif (strpos($jabatan, 'Bina Marga') !== false) {
                    $unit_kerja = 'bidang_bina_marga';
                } elseif (strpos($jabatan, 'Cipta Karya') !== false) {
                    $unit_kerja = 'bidang_cipta_karya';
                } elseif (strpos($jabatan, 'Sumber Daya Air') !== false) {
                    $unit_kerja = 'bidang_sumber_daya_air';
                } elseif (strpos($jabatan, 'Bina Konstruksi') !== false) {
                    $unit_kerja = 'bidang_tata_ruang';
                }

                Struktur::create([
                    'nama' => $member['nama'],
                    'jabatan' => $jabatan,
                    'nip' => $member['nip'],
                    'golongan' => $member['golongan'],
                    'unit_kerja' => $unit_kerja,
                    'urutan' => $urutan,
                    'status' => 'aktif',
                    'status_keaktifan' => 'aktif'
                ]);

                $urutan++;
            }
        }
    }
}
