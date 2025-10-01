<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Program;

class UpdateProgramStatuses extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'program:update-statuses
                          {--dry-run : Hanya tampilkan perubahan tanpa menyimpan}';

    /**
     * The console command description.
     */
    protected $description = 'Update status program berdasarkan tanggal mulai dan selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        $this->info('🔄 Memulai update status program...');

        // Ambil semua program yang tidak dibatalkan
        $programs = Program::whereNotIn('status', ['Selesai', 'Dibatalkan'])->get();

        $updatedCount = 0;
        $checkedCount = 0;

        foreach ($programs as $program) {
            $checkedCount++;
            $statusLama = $program->status;
            $statusBaru = $program->determineStatusByDate();

            if ($statusLama !== $statusBaru) {
                $this->line("📅 Program: {$program->nama_program}");
                $this->line("   Status: {$statusLama} → {$statusBaru}");

                if (!$isDryRun) {
                    $program->updateStatusByDate('auto_scheduler', 'Update otomatis oleh scheduler harian');
                    $this->info("   ✅ Status berhasil diperbarui");
                } else {
                    $this->warn("   🔍 [DRY RUN] Tidak ada perubahan disimpan");
                }

                $updatedCount++;
            }
        }

        $this->newLine();

        if ($isDryRun) {
            $this->warn("🔍 DRY RUN MODE - Tidak ada perubahan disimpan");
        }

        $this->info("📊 Hasil update:");
        $this->table(
            ['Metric', 'Jumlah'],
            [
                ['Program diperiksa', $checkedCount],
                ['Program diperbarui', $updatedCount],
                ['Program tidak berubah', $checkedCount - $updatedCount]
            ]
        );

        if ($updatedCount > 0 && !$isDryRun) {
            $this->info("✅ Update status program selesai. {$updatedCount} program diperbarui.");
        } elseif ($updatedCount === 0) {
            $this->info("✅ Semua status program sudah sesuai dengan tanggal.");
        }

        return Command::SUCCESS;
    }
}
