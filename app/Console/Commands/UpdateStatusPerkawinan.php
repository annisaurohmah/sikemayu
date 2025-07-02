<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sip4;

class UpdateStatusPerkawinan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sip4:update-status-perkawinan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status perkawinan untuk data SIP4 yang existing berdasarkan nama_suami';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai mengupdate status perkawinan untuk data SIP4 existing...');

        // Update records yang memiliki nama_suami menjadi 'menikah'
        $menikahCount = Sip4::whereNotNull('nama_suami')
            ->where('nama_suami', '!=', '')
            ->update(['status_perkawinan' => 'menikah']);

        $this->info("Updated {$menikahCount} records dengan status 'menikah'");

        // Update records yang tidak memiliki nama_suami menjadi 'belum_menikah'
        $belumMenikahCount = Sip4::where(function($q) {
            $q->whereNull('nama_suami')->orWhere('nama_suami', '');
        })->update(['status_perkawinan' => 'belum_menikah']);

        $this->info("Updated {$belumMenikahCount} records dengan status 'belum_menikah'");

        $this->info('Selesai mengupdate status perkawinan!');
        
        return 0;
    }
}
