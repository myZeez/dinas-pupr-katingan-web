<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Struktur;
use Illuminate\Support\Facades\DB;

class UpdateStrukturUnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping data lama ke enum baru
        $updateMappings = [
            'Sekretariat Jalan' => 'Seksi Jalan',
            'Sekretariat Jembatan' => 'Seksi Jembatan',
            'Sekretariat Perumahan' => 'Seksi Perumahan',
            'Sekretariat Air Minum' => 'Seksi Air Minum',
            'Sekretariat Sanitasi' => 'Seksi Sanitasi',
            'Bidang Sumber Daya Air' => 'Bidang SDA',
            // Data yang sudah sesuai tidak perlu diubah
        ];

        foreach ($updateMappings as $oldUnit => $newUnit) {
            DB::table('struktur')
                ->where('unit_kerja', $oldUnit)
                ->update(['unit_kerja' => $newUnit]);

            $this->command->info("Updated unit_kerja from '{$oldUnit}' to '{$newUnit}'");
        }

        // Update berdasarkan jabatan untuk data yang belum tepat
        $strukturs = Struktur::all();

        foreach ($strukturs as $struktur) {
            $correctUnitKerja = Struktur::getAutoUnitKerja($struktur->jabatan);

            if ($struktur->unit_kerja !== $correctUnitKerja) {
                $struktur->update(['unit_kerja' => $correctUnitKerja]);
                $this->command->info("Updated {$struktur->nama} unit_kerja to {$correctUnitKerja}");
            }
        }

        $this->command->info('Struktur unit_kerja data updated successfully!');
    }
}
