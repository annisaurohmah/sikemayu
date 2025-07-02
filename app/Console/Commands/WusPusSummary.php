<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sip4;
use App\Models\Posyandu;
use Illuminate\Support\Facades\DB;

class WusPusSummary extends Command
{
    protected $signature = 'summary:wus-pus';
    protected $description = 'Tampilkan summary data WUS/PUS per posyandu/RW';

    public function handle()
    {
        $this->info('📊 Summary Data WUS/PUS per Posyandu/RW:');
        $this->line('');

        $summary = Sip4::join('posyandu', 'sip_4.posyandu_id', '=', 'posyandu.posyandu_id')
            ->selectRaw('posyandu.posyandu_id, posyandu.nama_posyandu, COUNT(*) as total')
            ->groupBy('posyandu.posyandu_id', 'posyandu.nama_posyandu')
            ->orderBy('posyandu.posyandu_id')
            ->get();

        $totalData = 0;
        foreach ($summary as $row) {
            $rwNumber = str_pad(substr($row->nama_posyandu, -2), 2, '0', STR_PAD_LEFT);
            $this->line("  RW {$rwNumber} ({$row->nama_posyandu}): {$row->total} data WUS/PUS");
            $totalData += $row->total;
        }

        $this->line('');
        $this->info("📈 Total keseluruhan: {$totalData} data WUS/PUS");

        // Cek posyandu yang belum ada data
        $posyanduTanpaData = Posyandu::leftJoin('sip_4', 'posyandu.posyandu_id', '=', 'sip_4.posyandu_id')
            ->whereNull('sip_4.posyandu_id')
            ->select('posyandu.posyandu_id', 'posyandu.nama_posyandu')
            ->orderBy('posyandu.posyandu_id')
            ->get();

        if ($posyanduTanpaData->count() > 0) {
            $this->line('');
            $this->warn('⚠️  Posyandu yang belum ada data WUS/PUS:');
            foreach ($posyanduTanpaData as $posyandu) {
                $rwNumber = str_pad(substr($posyandu->nama_posyandu, -2), 2, '0', STR_PAD_LEFT);
                $this->line("  RW {$rwNumber} ({$posyandu->nama_posyandu})");
            }
        }

        return Command::SUCCESS;
    }
}
