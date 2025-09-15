<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Struktur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'struktur';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'golongan',
        'unit_kerja',
        'urutan',
        'status',
        'foto',
        'memerlukan_plt',
        'plt_struktur_id',
        'plt_nama_manual',
        'plt_jabatan_manual',
        'plt_asal_instansi',
        'plt_mulai',
        'plt_selesai',
        'plt_status',
        'plt_keterangan'
    ];

    protected $casts = [
        'urutan' => 'integer',
        'memerlukan_plt' => 'boolean',
        'plt_mulai' => 'date',
        'plt_selesai' => 'date'
    ];

    // Static method to get jabatan categories
    public static function getJabatanCategories()
    {
        return [
            'pimpinan' => 'Pimpinan',
            'sekretariat' => 'Sekretariat',
            'bina_marga' => 'Bidang Bina Marga',
            'cipta_karya' => 'Bidang Cipta Karya',
            'tata_ruang' => 'Bidang Tata Ruang dan Bina Konstruksi',
            'sumber_daya_air' => 'Bidang Sumber Daya Air',
            'staff_umum' => 'Staff Umum'
        ];
    }

    // Static method to get jabatan categories with their options
    public static function getJabatanCategoriesWithOptions()
    {
        $jabatanData = [
            'pimpinan' => [
                'Kepala Dinas',
                'Sekretaris',
            ],
            'sekretariat' => [
                'Kepala Subbagian Umum dan Kepegawaian',
                'Kepala Subbagian Keuangan, Perencanaan, Evaluasi dan Pelaporan',
            ],
            'bina_marga' => [
                'Kepala Bidang Bina Marga',
                'Penata Kelola Jalan dan Jembatan Ahli Muda',
                'Penata Kelola Jalan dan Jembatan Ahli Pertama',
                'Pengawas Jaringan Utilitas',
                'Penelaah Teknis Kebijakan',
                'Pengadministrasi Perkantoran',
                'Operator Layanan Operasional',
                'Teknisi Laboratorium',
                'Penata Kelola Sistem dan Teknologi Informasi',
                'Penata Layanan Operasional',
            ],
            'cipta_karya' => [
                'Kepala Bidang Cipta Karya',
                'Penata Kelola Bangunan Gedung dan Kawasan Permukiman Ahli Muda',
                'Penata Kelola Penyeliatan Lingkungan Ahli Muda',
                'Perencana Ahli Muda',
                'Analis Kebijakan Ahli Muda',
                'Penata Ruang Ahli Pertama',
                'Penata Kelola Bangunan Gedung dan Kawasan Permukiman Ahli Pertama',
                'Penata Kelola Penyeliatan Lingkungan Ahli Pertama',
                'Penata Bangunan Gedung dan Permukiman Ahli Pertama',
                'Penata Kelola Jalan dan Jembatan Ahli Pertama',
                'Pengawas Jaringan Utilitas',
                'Penata Layanan Operasional',
                'Penata Komputer Ahli Pertama',
                'Analis Kebijakan Ahli Pertama',
                'Penelaah Teknis Kebijakan',
            ],
            'tata_ruang' => [
                'Kepala Bidang Tata Ruang dan Bina Konstruksi',
                'Penata Ruang Ahli Muda',
                'Pembina Jasa Konstruksi Ahli Muda',
                'Penata Ruang Ahli Pertama',
                'Pembina Jasa Konstruksi Ahli Pertama',
                'Penata Kelola Jalan dan Jembatan Ahli Pertama',
                'Analis Kebijakan Ahli Pertama',
                'Penelaah Teknis Kebijakan',
                'Penata Layanan Operasional',
            ],
            'sumber_daya_air' => [
                'Kepala Bidang Sumber Daya Air',
                'Penata Kelola Sumber Daya Air Ahli Muda',
                'Penata Kelola Sumber Daya Air Ahli Pertama',
                'Analis Kebijakan Ahli Pertama',
                'Penelaah Teknis Kebijakan',
                'Penata Layanan Operasional',
            ],
            'staff_umum' => [
                'Pengemudi',
                'Pengadministrasi Perkantoran',
                'Operator Layanan Operasional',
                'Teknisi Laboratorium',
                'Penata Kelola Sistem dan Teknologi Informasi',
                'Penata Layanan Operasional',
                'Penata Komputer Ahli Pertama',
                'Operator Komputer',
                'Pramu Kantor',
            ]
        ];

        return $jabatanData;
    }

    // Static method to get jabatan options by category
    public static function getJabatanByCategory($category = null)
    {
        $jabatanData = [
            'pimpinan' => [
                'Kepala Dinas',
                'Sekretaris',
            ],
            'sekretariat' => [
                'Kepala Subbagian Umum dan Kepegawaian',
                'Kepala Subbagian Keuangan, Perencanaan, Evaluasi dan Pelaporan',
            ],
            'bina_marga' => [
                'Kepala Bidang Bina Marga',
                'Penata Kelola Jalan dan Jembatan Ahli Muda',
                'Penata Kelola Jalan dan Jembatan Ahli Pertama',
                'Pengawas Jaringan Utilitas',
                'Penelaah Teknis Kebijakan',
                'Pengadministrasi Perkantoran',
                'Operator Layanan Operasional',
                'Teknisi Laboratorium',
                'Penata Kelola Sistem dan Teknologi Informasi',
                'Penata Layanan Operasional',
            ],
            'cipta_karya' => [
                'Kepala Bidang Cipta Karya',
                'Penata Kelola Bangunan Gedung dan Kawasan Permukiman Ahli Muda',
                'Penata Kelola Penyeliatan Lingkungan Ahli Muda',
                'Perencana Ahli Muda',
                'Analis Kebijakan Ahli Muda',
                'Penata Ruang Ahli Pertama',
                'Penata Kelola Bangunan Gedung dan Kawasan Permukiman Ahli Pertama',
                'Penata Kelola Penyeliatan Lingkungan Ahli Pertama',
                'Penata Bangunan Gedung dan Permukiman Ahli Pertama',
                'Penata Kelola Jalan dan Jembatan Ahli Pertama',
                'Pengawas Jaringan Utilitas',
                'Penata Layanan Operasional',
                'Penata Komputer Ahli Pertama',
                'Analis Kebijakan Ahli Pertama',
                'Penelaah Teknis Kebijakan',
            ],
            'tata_ruang' => [
                'Kepala Bidang Tata Ruang dan Bina Konstruksi',
                'Penata Ruang Ahli Muda',
                'Pembina Jasa Konstruksi Ahli Muda',
                'Penata Ruang Ahli Pertama',
                'Penelaah Teknis Kebijakan',
                'Pengadministrasi Perkantoran',
                'Surveyor Pemetaan Ahli Pertama',
                'Penata Kelola Sistem dan Teknologi Informasi',
                'Penata Layanan Operasional',
                'Operator Alat Berat',
            ],
            'sumber_daya_air' => [
                'Kepala Bidang Sumber Daya Air',
                'Pengelola Sumber Daya Air Ahli Muda',
                'Pengelola Sumber Daya Air Ahli Pertama',
                'Pengamat Koperasi dan Pemeliharaan SDA',
                'Penelaah Teknis Kebijakan',
                'Petugas Operasi dan Pemeliharaan',
                'Pengadministrasi Perkantoran',
                'Operator Sumber Daya Air',
                'Penata Layanan Operasional',
                'Penata Laksana Sumber Daya Air Pemula',
            ],
            'staff_umum' => [
                'Penata Kelola Jalan dan Jembatan Ahli Muda',
                'Pembina Jasa Konstruksi Ahli Muda',
                'Penata Kelola Bangunan Gedung dan Kawasan Permukiman Ahli Muda',
                'Pengelola Sumber Daya Air Ahli Muda',
                'Penata Ruang Ahli Muda',
                'Penata Kelola Penyeliatan Lingkungan Ahli Muda',
                'Perencana Ahli Muda',
                'Analis Kebijakan Ahli Muda',
                'Perencana Ahli Muda',
                'Kepala Seksi Irigasi',
                'Kepala Seksi Sungai',
                'Staff Ahli',
                'Staff'
            ]
        ];

        if ($category && isset($jabatanData[$category])) {
            return $jabatanData[$category];
        }

        // Return all jabatan if no category specified
        return array_merge(...array_values($jabatanData));
    }

    // Static method to get jabatan options (maintain backward compatibility)
    public static function getJabatanOptions()
    {
        return static::getJabatanByCategory();
    }

    // Static method to get unit kerja options
    public static function getUnitKerjaOptions()
    {
        return [
            'Dinas PUPR',
            'Kepala Dinas',
            'Sekretariat',
            'Subbagian Umum dan Kepegawaian',
            'Sub Bagian Umum & Kepegawaian',
            'Subbagian Keuangan, Perencanaan, Evaluasi dan Pelaporan',
            'Sub Bagian Keuangan',
            'Sub Bagian Perencanaan / Program',
            'Bidang Bina Marga',
            'Seksi Jalan',
            'Seksi Jembatan',
            'Bidang Cipta Karya',
            'Seksi Perumahan',
            'Seksi Air Minum',
            'Seksi Sanitasi',
            'Bidang Tata Ruang dan Bina Konstruksi',
            'Bidang Penataan Ruang',
            'Seksi Perencanaan Tata Ruang',
            'Seksi Pengendalian Pemanfaatan Ruang',
            'Bidang Sumber Daya Air',
            'Seksi Irigasi',
            'Seksi Sungai',
            'UPT / Unit Pelaksana Teknis',
            'Tim Teknis / Proyek Tertentu'
        ];
    }

    // Static method to get golongan options
    public static function getGolonganOptions()
    {
        return [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];
    }

    // Get next urutan number
    public static function getNextUrutan()
    {
        return static::max('urutan') + 1;
    }

    // Auto-fill methods for form
    public static function getAutoUnitKerja($jabatan)
    {
        $mapping = static::getAutoFillMapping();
        return $mapping[$jabatan]['unit_kerja'] ?? '';
    }

    public static function getAutoGolongan($jabatan)
    {
        $mapping = static::getAutoFillMapping();
        return $mapping[$jabatan]['golongan'] ?? '';
    }

    public static function getAutoUrutan($jabatan)
    {
        $mapping = static::getAutoFillMapping();
        return $mapping[$jabatan]['urutan'] ?? 1;
    }

    // Auto-fill mapping
    private static function getAutoFillMapping()
    {
        return [
            'Kepala Dinas' => ['unit_kerja' => 'Dinas PUPR', 'golongan' => 'IV/d', 'urutan' => 1],
            'Sekretaris Dinas' => ['unit_kerja' => 'Sekretariat', 'golongan' => 'IV/c', 'urutan' => 2],
            'Kepala Sub Bagian Umum' => ['unit_kerja' => 'Sub Bagian Umum & Kepegawaian', 'golongan' => 'III/d', 'urutan' => 3],
            'Kepala Sub Bagian Keuangan' => ['unit_kerja' => 'Sub Bagian Keuangan', 'golongan' => 'III/d', 'urutan' => 4],
            'Kepala Sub Bagian Program' => ['unit_kerja' => 'Sub Bagian Perencanaan / Program', 'golongan' => 'III/d', 'urutan' => 5],
            'Kepala Bidang Bina Marga' => ['unit_kerja' => 'Bidang Bina Marga', 'golongan' => 'IV/b', 'urutan' => 6],
            'Kepala Seksi Jalan' => ['unit_kerja' => 'Seksi Jalan', 'golongan' => 'III/c', 'urutan' => 7],
            'Kepala Seksi Jembatan' => ['unit_kerja' => 'Seksi Jembatan', 'golongan' => 'III/c', 'urutan' => 8],
            'Kepala Bidang Cipta Karya' => ['unit_kerja' => 'Bidang Cipta Karya', 'golongan' => 'IV/b', 'urutan' => 9],
            'Kepala Seksi Perumahan' => ['unit_kerja' => 'Seksi Perumahan', 'golongan' => 'III/c', 'urutan' => 10],
            'Kepala Seksi Air Minum' => ['unit_kerja' => 'Seksi Air Minum', 'golongan' => 'III/c', 'urutan' => 11],
            'Kepala Seksi Sanitasi' => ['unit_kerja' => 'Seksi Sanitasi', 'golongan' => 'III/c', 'urutan' => 12],
            'Kepala Bidang Penataan Ruang' => ['unit_kerja' => 'Bidang Penataan Ruang', 'golongan' => 'IV/b', 'urutan' => 13],
            'Kepala Seksi Perencanaan' => ['unit_kerja' => 'Seksi Perencanaan Tata Ruang', 'golongan' => 'III/c', 'urutan' => 14],
            'Kepala Seksi Pengendalian' => ['unit_kerja' => 'Seksi Pengendalian Pemanfaatan Ruang', 'golongan' => 'III/c', 'urutan' => 15],
            'Kepala Bidang Sumber Daya Air' => ['unit_kerja' => 'Bidang Sumber Daya Air', 'golongan' => 'IV/b', 'urutan' => 16],
            'Kepala Seksi Irigasi' => ['unit_kerja' => 'Seksi Irigasi', 'golongan' => 'III/c', 'urutan' => 17],
            'Kepala Seksi Sungai' => ['unit_kerja' => 'Seksi Sungai', 'golongan' => 'III/c', 'urutan' => 18],
            'Staff Ahli' => ['unit_kerja' => 'Dinas PUPR', 'golongan' => 'IV/a', 'urutan' => 19],
            'Staff' => ['unit_kerja' => 'Dinas PUPR', 'golongan' => 'III/a', 'urutan' => 20]
        ];
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    public function scopeByJabatanHierarchy($query)
    {
        // Define jabatan hierarchy order
        $jabatanOrder = [
            'Kepala Dinas' => 1,
            'Sekretaris Dinas' => 2,
            'Kepala Sub Bagian Umum' => 3,
            'Kepala Sub Bagian Keuangan' => 4,
            'Kepala Sub Bagian Program' => 5,
            'Kepala Bidang Bina Marga' => 6,
            'Kepala Seksi Jalan' => 7,
            'Kepala Seksi Jembatan' => 8,
            'Kepala Bidang Cipta Karya' => 9,
            'Kepala Seksi Perumahan' => 10,
            'Kepala Seksi Air Minum' => 11,
            'Kepala Seksi Sanitasi' => 12,
            'Kepala Bidang Penataan Ruang' => 13,
            'Kepala Seksi Perencanaan' => 14,
            'Kepala Seksi Pengendalian' => 15,
            'Kepala Bidang Sumber Daya Air' => 16,
            'Kepala Seksi Irigasi' => 17,
            'Kepala Seksi Sungai' => 18,
            'Staff Ahli' => 19,
            'Staff' => 20
        ];

        return $query->orderByRaw("FIELD(jabatan, '" . implode("','", array_keys($jabatanOrder)) . "')")
            ->orderBy('urutan', 'asc');
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Jika path sudah lengkap dengan foto/struktur/, gunakan storage
            if (strpos($this->foto, 'foto/struktur/') === 0) {
                return asset('storage/' . $this->foto);
            }
            // Jika hanya nama file, tambahkan path lengkap
            else if (!str_contains($this->foto, '/')) {
                return asset('storage/foto/struktur/' . $this->foto);
            }
            // Fallback untuk path lain
            else {
                return asset('storage/' . $this->foto);
            }
        }
        return asset('Icon/loading.gif');
    }

    public function getJabatanLabelAttribute()
    {
        return $this->jabatan;
    }

    // Relations for hierarchical structure (simulated)
    public function getChildrenAttribute()
    {
        // Since we don't have parent_id, return empty collection
        // This is to prevent errors in the view
        return collect();
    }

    // PLT Relations
    public function pltStruktur()
    {
        return $this->belongsTo(Struktur::class, 'plt_struktur_id');
    }

    public function strukturDenganPlt()
    {
        return $this->hasMany(Struktur::class, 'plt_struktur_id');
    }

    // PLT Methods
    public function getStatusKeaktifanOptions()
    {
        return [
            'aktif' => 'Aktif',
            'pensiun' => 'Pensiun',
            'mutasi' => 'Mutasi',
            'cuti_panjang' => 'Cuti Panjang'
        ];
    }

    public static function getStatusKeaktifanOptionsStatic()
    {
        return [
            'aktif' => 'Aktif',
            'pensiun' => 'Pensiun',
            'mutasi' => 'Mutasi',
            'cuti_panjang' => 'Cuti Panjang'
        ];
    }

    public function getPltNamaAttribute()
    {
        if ($this->plt_struktur_id && $this->pltStruktur) {
            return $this->pltStruktur->nama;
        }
        return $this->plt_nama_manual;
    }

    public function getPltJabatanAttribute()
    {
        if ($this->plt_struktur_id && $this->pltStruktur) {
            return $this->pltStruktur->jabatan;
        }
        return $this->plt_jabatan_manual;
    }

    public function getPltFotoUrlAttribute()
    {
        if ($this->plt_struktur_id && $this->pltStruktur && $this->pltStruktur->foto) {
            return $this->pltStruktur->foto_url;
        }
        return asset('Icon/loading.gif');
    }

    public function isPltActive()
    {
        if (!$this->memerlukan_plt) return false;

        $today = now()->format('Y-m-d');

        if ($this->plt_mulai && $this->plt_selesai) {
            return $today >= $this->plt_mulai->format('Y-m-d') && $today <= $this->plt_selesai->format('Y-m-d');
        }

        if ($this->plt_mulai) {
            return $today >= $this->plt_mulai->format('Y-m-d');
        }

        return true;
    }

    public function getEligibleForPlt()
    {
        return static::where('id', '!=', $this->id)
            ->where('status', 'aktif')
            ->whereIn('jabatan', [
                'Sekretaris',
                'Kepala Bidang Bina Marga',
                'Kepala Bidang Cipta Karya',
                'Kepala Bidang Tata Ruang dan Bina Konstruksi',
                'Kepala Bidang Sumber Daya Air'
            ])
            ->orderBy('urutan')
            ->get();
    }

    // Scopes for PLT
    public function scopeMemerlukanPlt($query)
    {
        return $query->where('memerlukan_plt', true);
    }

    public function scopePltAktif($query)
    {
        $today = now()->format('Y-m-d');
        return $query->where('memerlukan_plt', true)
            ->where(function ($q) use ($today) {
                $q->where(function ($q2) use ($today) {
                    // PLT dengan tanggal mulai dan selesai
                    $q2->whereNotNull('plt_mulai')
                        ->whereNotNull('plt_selesai')
                        ->whereDate('plt_mulai', '<=', $today)
                        ->whereDate('plt_selesai', '>=', $today);
                })
                    ->orWhere(function ($q2) use ($today) {
                        // PLT dengan tanggal mulai saja (belum ada tanggal selesai)
                        $q2->whereNotNull('plt_mulai')
                            ->whereNull('plt_selesai')
                            ->whereDate('plt_mulai', '<=', $today);
                    })
                    ->orWhere(function ($q2) {
                        // PLT tanpa tanggal (langsung aktif)
                        $q2->whereNull('plt_mulai')
                            ->whereNull('plt_selesai');
                    });
            });
    }
}
