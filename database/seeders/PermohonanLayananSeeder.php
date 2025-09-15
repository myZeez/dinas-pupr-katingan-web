<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermohonanLayanan;

class PermohonanLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permohonanData = [
            [
                'nomor_permohonan' => 'PL-2024-001',
                'nama_pemohon' => 'Andi Wijaya',
                'nik' => '6202012801850001',
                'email' => 'andi.wijaya@email.com',
                'telepon' => '0812-3456-7890',
                'alamat' => 'Jl. Veteran No. 45, Kasongan',
                'jenis_layanan' => 'Izin Mendirikan Bangunan (IMB)',
                'jenis_layanan_code' => 'IMB',
                'deskripsi' => 'Permohonan IMB untuk pembangunan rumah tinggal seluas 120 m2',
                'dokumen_persyaratan' => json_encode([
                    'ktp' => 'dokumen/ktp_andi_wijaya.pdf',
                    'sertifikat_tanah' => 'dokumen/sertifikat_tanah_andi.pdf',
                    'gambar_bangunan' => 'dokumen/gambar_bangunan_andi.pdf'
                ]),
                'status' => 'diproses',
                'tanggal_permohonan' => now()->subDays(10),
                'admin_id' => 1,
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(8),
            ],
            [
                'nomor_permohonan' => 'PL-2024-002',
                'nama_pemohon' => 'Siti Nurhaliza',
                'nik' => '6202015612900002',
                'email' => 'siti.nurhaliza@email.com',
                'telepon' => '0813-9876-5432',
                'alamat' => 'Jl. Diponegoro No. 23, Katingan Tengah',
                'jenis_layanan' => 'Izin Usaha Perdagangan (IUP)',
                'jenis_layanan_code' => 'IUP',
                'deskripsi' => 'Permohonan IUP untuk usaha material bangunan',
                'dokumen_persyaratan' => json_encode([
                    'ktp' => 'dokumen/ktp_siti_nurhaliza.pdf',
                    'npwp' => 'dokumen/npwp_siti.pdf',
                    'akta_usaha' => 'dokumen/akta_usaha_siti.pdf'
                ]),
                'status' => 'selesai',
                'tanggal_permohonan' => now()->subDays(20),
                'tanggal_selesai' => now()->subDays(5),
                'catatan_admin' => 'Permohonan telah disetujui dan dokumen izin telah diterbitkan',
                'file_hasil' => 'hasil/iup_siti_nurhaliza.pdf',
                'admin_id' => 1,
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(5),
            ],
            [
                'nomor_permohonan' => 'PL-2024-003',
                'nama_pemohon' => 'Budi Santoso',
                'nik' => '6202013004800003',
                'email' => 'budi.santoso@email.com',
                'telepon' => '0814-5678-9012',
                'alamat' => 'Desa Kereng Bangkirai, Katingan Kuala',
                'jenis_layanan' => 'Surat Keterangan Rencana Kota (SKRK)',
                'jenis_layanan_code' => 'SKRK',
                'deskripsi' => 'Permohonan SKRK untuk keperluan pengajuan kredit bank',
                'dokumen_persyaratan' => json_encode([
                    'ktp' => 'dokumen/ktp_budi_santoso.pdf',
                    'surat_tanah' => 'dokumen/surat_tanah_budi.pdf'
                ]),
                'status' => 'menunggu',
                'tanggal_permohonan' => now()->subDays(3),
                'admin_id' => 1,
                'ip_address' => '192.168.1.102',
                'user_agent' => 'Mozilla/5.0 (Android 10; Mobile; rv:81.0) Gecko/81.0 Firefox/81.0',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'nomor_permohonan' => 'PL-2024-004',
                'nama_pemohon' => 'Dewi Kartika',
                'nik' => '6202014509750004',
                'email' => 'dewi.kartika@email.com',
                'telepon' => '0815-2468-1357',
                'alamat' => 'Jl. Ahmad Yani No. 78, Kasongan',
                'jenis_layanan' => 'Izin Lingkungan',
                'jenis_layanan_code' => 'IL',
                'deskripsi' => 'Permohonan izin lingkungan untuk usaha bengkel motor',
                'dokumen_persyaratan' => json_encode([
                    'ktp' => 'dokumen/ktp_dewi_kartika.pdf',
                    'dokumen_lingkungan' => 'dokumen/amdal_dewi.pdf',
                    'surat_usaha' => 'dokumen/surat_usaha_dewi.pdf'
                ]),
                'status' => 'ditolak',
                'tanggal_permohonan' => now()->subDays(15),
                'catatan_admin' => 'Dokumen AMDAL belum lengkap, mohon melengkapi terlebih dahulu',
                'admin_id' => 1,
                'ip_address' => '192.168.1.103',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(12),
            ],
        ];

        foreach ($permohonanData as $data) {
            PermohonanLayanan::create($data);
        }
    }
}
