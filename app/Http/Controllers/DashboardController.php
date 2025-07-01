<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\Rw;
use App\Models\Penduduk;
use App\Models\Anak;
use App\Models\Dw;
use App\Models\Sip1;
use App\Models\Sip2;
use App\Models\Sip3;
use App\Models\Sip4;
use App\Models\Sip5;
use Illuminate\Support\Facades\DB;
use App\Traits\HasDataAccess;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use HasDataAccess;
    
    public function getDashboardUtama(Request $request)
    {
        // Get the selected year from request or use current year as default
        $tahun = $request->get('tahun', now()->year);
        
        // Get user access data
        $access = $this->getDataAccess();
        
        // Get SKDN data for all RW/villages
        $skdnData = $this->getSKDNData($access, $tahun);
        
        // Extract individual variables for the view
        extract($skdnData);
        
        return view('sip.dashboard_utama', compact('tahun', 'access', 'labels', 'dataS', 'dataK', 'dataD', 'dataN', 'persenK', 'persenD', 'persenN'));
    }

    public function getDashboard(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $access = $this->getDataAccess();
        
        // Get statistics based on user access level
        $stats = $this->getStatistics($access, $tahun);
        
        return view('admin.dashboard', compact('tahun', 'stats', 'access'));
    }

    private function getStatistics($access, $tahun)
    {
        $stats = [];
        
        try {
            // Basic counts
            $stats['total_users'] = $access['can_access_all'] ? User::count() : 0;
            $stats['total_posyandu'] = $access['can_access_all'] ? Posyandu::count() : 
                ($access['can_access_posyandu_only'] ? 1 : 0);
            $stats['total_rw'] = $access['can_access_all'] ? Rw::count() : 
                ($access['can_access_rw_only'] ? 1 : 0);
            
            // Population data
            if ($access['can_access_all']) {
                $stats['total_penduduk'] = Penduduk::count();
                // Bayi: 0-11 bulan dan 11+1 hari (kurang dari 12 bulan)
                $stats['total_bayi'] = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) < 12')->count();
                // Balita: 12-59 bulan (1 tahun sampai kurang dari 5 tahun)
                $stats['total_balita'] = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) >= 12 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) < 60')->count();
            } else {
                $stats['total_penduduk'] = 0;
                $stats['total_bayi'] = 0;
                $stats['total_balita'] = 0;
            }
            
            // Dasawisma data (count all, not filtered by year for dashboard cards)
            if ($access['can_access_all'] || $access['can_access_rw_only']) {
                try {
                    $dwQuery = Dw::query(); // Remove year filter for total count
                    if ($access['can_access_rw_only']) {
                        try {
                            $dwQuery->whereHas('rw', function($q) use ($access) {
                                $q->where('no_rw', $access['rw']);
                            });
                        } catch (\Exception $e) {
                            // If relationship doesn't work, try direct join
                            $dwQuery = Dw::join('rw', 'rw.rw_id', '=', 'dw.rw_id')
                                     ->where('rw.no_rw', $access['rw'])
                                     ->select('dw.*');
                        }
                    }
                    $stats['total_dasawisma'] = $dwQuery->count();
                } catch (\Exception $e) {
                    $stats['total_dasawisma'] = 0;
                }
            } else {
                $stats['total_dasawisma'] = 0;
            }
            
            // SIP data (count all records, not filtered by year for dashboard cards)
            if ($access['can_access_all'] || $access['can_access_posyandu_only']) {
                $posyanduFilter = $access['can_access_posyandu_only'] ? 
                    Posyandu::where('nama_posyandu', $access['posyandu'])->first() : null;
                
                $stats['total_sip1'] = $posyanduFilter ? 
                    Sip1::where('posyandu_id', $posyanduFilter->posyandu_id)->count() : 
                    ($access['can_access_all'] ? Sip1::count() : 0);
                    
                $stats['total_sip2'] = $posyanduFilter ? 
                    Sip2::where('posyandu_id', $posyanduFilter->posyandu_id)->count() : 
                    ($access['can_access_all'] ? Sip2::count() : 0);
                    
                $stats['total_sip3'] = $posyanduFilter ? 
                    Sip3::where('posyandu_id', $posyanduFilter->posyandu_id)->count() : 
                    ($access['can_access_all'] ? Sip3::count() : 0);
            } else {
                $stats['total_sip1'] = 0;
                $stats['total_sip2'] = 0;
                $stats['total_sip3'] = 0;
            }
            
            // Monthly data for charts
            $stats['monthly_data'] = $this->getMonthlyData($access, $tahun);
            $stats['gender_data'] = $this->getGenderData($access);
            $stats['age_distribution'] = $this->getAgeDistribution($access);
            
        } catch (\Exception $e) {
            // If there's any error, return default values
            $stats = [
                'total_users' => 0,
                'total_posyandu' => 0,
                'total_rw' => 0,
                'total_penduduk' => 0,
                'total_bayi' => 0,
                'total_balita' => 0,
                'total_dasawisma' => 0,
                'total_sip1' => 0,
                'total_sip2' => 0,
                'total_sip3' => 0,
                'monthly_data' => ['dasawisma' => [], 'sip' => []],
                'gender_data' => ['male' => 0, 'female' => 0],
                'age_distribution' => ['bayi' => 0, 'balita' => 0, 'anak' => 0, 'dewasa' => 0, 'lansia' => 0]
            ];
        }
        
        return $stats;
    }

    private function getMonthlyData($access, $tahun)
    {
        $monthlyData = ['dasawisma' => [], 'sip' => []];
        
        try {
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date('M', mktime(0, 0, 0, $month, 1));
                
                if ($access['can_access_all'] || $access['can_access_rw_only']) {
                    try {
                        $dwQuery = Dw::where('tahun', $tahun)->where('bulan', $month);
                        
                        if ($access['can_access_rw_only']) {
                            try {
                                $dwQuery->whereHas('rw', function($q) use ($access) {
                                    $q->where('no_rw', $access['rw']);
                                });
                            } catch (\Exception $e) {
                                // If relationship doesn't work, try direct join
                                $dwQuery = Dw::join('rw', 'rw.rw_id', '=', 'dw.rw_id')
                                         ->where('dw.tahun', $tahun)
                                         ->where('dw.bulan', $month)
                                         ->where('rw.no_rw', $access['rw']);
                            }
                        }
                        
                        $monthlyData['dasawisma'][$monthName] = $dwQuery->count();
                    } catch (\Exception $e) {
                        $monthlyData['dasawisma'][$monthName] = 0;
                    }
                } else {
                    $monthlyData['dasawisma'][$monthName] = 0;
                }
                
                if ($access['can_access_all'] || $access['can_access_posyandu_only']) {
                    try {
                        $posyanduFilter = $access['can_access_posyandu_only'] ? 
                            Posyandu::where('nama_posyandu', $access['posyandu'])->first() : null;
                        
                        // Use tgl_lahir column if available, otherwise just count all records
                        $sipQuery = Sip2::query();
                        
                        // Try to filter by date if tgl_lahir column exists and is not null
                        try {
                            $sipQuery->whereMonth('tgl_lahir', $month)->whereYear('tgl_lahir', $tahun);
                        } catch (\Exception $e) {
                            // If tgl_lahir doesn't exist or has issues, just get total count
                            $sipQuery = Sip2::query();
                        }
                        
                        if ($posyanduFilter) {
                            $sipQuery->where('posyandu_id', $posyanduFilter->posyandu_id);
                        }
                        
                        $monthlyData['sip'][$monthName] = $sipQuery->count();
                    } catch (\Exception $e) {
                        $monthlyData['sip'][$monthName] = 0;
                    }
                } else {
                    $monthlyData['sip'][$monthName] = 0;
                }
            }
        } catch (\Exception $e) {
            // Return empty data if there's an error
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date('M', mktime(0, 0, 0, $month, 1));
                $monthlyData['dasawisma'][$monthName] = 0;
                $monthlyData['sip'][$monthName] = 0;
            }
        }
        
        return $monthlyData;
    }

    private function getGenderData($access)
    {
        if (!$access['can_access_all']) {
            return ['male' => 0, 'female' => 0];
        }
        
        try {
            return [
                'male' => Penduduk::where('jenis_kelamin', 'L')->count(),
                'female' => Penduduk::where('jenis_kelamin', 'P')->count()
            ];
        } catch (\Exception $e) {
            return ['male' => 0, 'female' => 0];
        }
    }

    private function getAgeDistribution($access)
    {
        if (!$access['can_access_all']) {
            return ['bayi' => 0, 'balita' => 0, 'anak' => 0, 'dewasa' => 0, 'lansia' => 0];
        }
        
        try {
            return [
                // Bayi: 0-11 bulan dan 11+1 hari (kurang dari 12 bulan)
                'bayi' => Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) < 12')->count(),
                // Balita: 12-59 bulan (1 tahun sampai kurang dari 5 tahun)
                'balita' => Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) >= 12 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) < 60')->count(),
                // Anak: 5-17 tahun
                'anak' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) BETWEEN 5 AND 17')->count(),
                'dewasa' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) BETWEEN 18 AND 59')->count(),
                'lansia' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) >= 60')->count()
            ];
        } catch (\Exception $e) {
            // If there's an error with date calculations, return zeros
            return ['bayi' => 0, 'balita' => 0, 'anak' => 0, 'dewasa' => 0, 'lansia' => 0];
        }
    }

    public function getAdminDashboard(Request $request)
    {
        // Ambil tahun dari parameter URL atau gunakan tahun sekarang sebagai default
        $tahun = $request->get('tahun', now()->year);
        
        // Logic to retrieve and display admin dashboard data
        return view('admin.dashboard', compact('tahun'));
    }

    public function getUsers()
    {
        // Logic to retrieve and display users
        return view('admin.users.index');
    }

    public function createUser(Request $request)
    {
        // Logic to create a new user
        // Validate and save user data
        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        // Logic to update an existing user
        // Validate and update user data
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        // Logic to delete a user
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    private function getSKDNData($access, $tahun)
    {
        try {
            // Initialize data arrays
            $labels = [];
            $dataS = []; // Sasaran (Total bayi + balita)
            $dataK = []; // Kartu (Yang punya buku/kartu)
            $dataD = []; // Ditimbang
            $dataN = []; // Naik berat badan
            
            // Get months for the selected year
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $bulanNama = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];
                $labels[] = $bulanNama[$bulan];
                
                // Initialize counters for this month
                $totalSasaran = 0;
                $totalKartu = 0;
                $totalDitimbang = 0;
                $totalNaik = 0;
                
                // Get all posyandu based on access level
                $posyanduQuery = Posyandu::query();
                
                if ($access['can_access_posyandu_only']) {
                    $posyanduQuery->where('nama_posyandu', $access['posyandu']);
                } elseif ($access['can_access_rw_only']) {
                    // Filter by RW if user only has RW access
                    $posyanduQuery->whereHas('rw', function($q) use ($access) {
                        $q->where('no_rw', $access['rw']);
                    });
                }
                // For admin_desa (can_access_all), get all posyandu
                
                $posyanduList = $posyanduQuery->get();
                
                foreach ($posyanduList as $posyandu) {
                    $posyandu_id = $posyandu->posyandu_id;
                    
                    // Hitung Sasaran (S) - Total bayi + balita per bulan
                    // Bayi: 0-11 bulan pada bulan tersebut
                    $tanggalAcuan = \Carbon\Carbon::create($tahun, $bulan, 1);
                    
                    $bayiCount = Sip2::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) < 12", [$tanggalAcuan])
                        ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) >= 0", [$tanggalAcuan])
                        ->where('posyandu_id', $posyandu_id)
                        ->whereYear('tgl_lahir', '>=', $tahun - 1)
                        ->whereYear('tgl_lahir', '<=', $tahun)
                        ->count();
                    
                    // Balita: 12-59 bulan pada bulan tersebut
                    $balitaCount = Sip3::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) >= 12 AND TIMESTAMPDIFF(MONTH, tgl_lahir, ?) < 60", [
                        $tanggalAcuan, $tanggalAcuan
                    ])->where('posyandu_id', $posyandu_id)
                      ->whereYear('tgl_lahir', '>=', $tahun - 5)
                      ->whereYear('tgl_lahir', '<=', $tahun)
                      ->count();
                    
                    $sasaran = $bayiCount + $balitaCount;
                    
                    // Hitung Kartu (K) - Yang memiliki buku/kartu
                    $kartuBayi = Sip2::where('posyandu_id', $posyandu_id)
                        ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) < 12", [$tanggalAcuan])
                        ->whereYear('tgl_lahir', '>=', $tahun - 1)
                        ->whereYear('tgl_lahir', '<=', $tahun)
                        ->whereNotNull('nama_bayi') // Asumsi jika ada nama berarti punya kartu
                        ->count();
                    
                    $kartuBalita = Sip3::where('posyandu_id', $posyandu_id)
                        ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) >= 12 AND TIMESTAMPDIFF(MONTH, tgl_lahir, ?) < 60", [
                            $tanggalAcuan, $tanggalAcuan
                        ])
                        ->whereYear('tgl_lahir', '>=', $tahun - 5)
                        ->whereYear('tgl_lahir', '<=', $tahun)
                        ->whereNotNull('nama_balita')
                        ->count();
                    
                    $kartu = $kartuBayi + $kartuBalita;
                    
                    // Hitung Ditimbang (D) - Yang ditimbang pada bulan tersebut
                    $ditimbangBayi = DB::table('sip_2')
                        ->join('sip2_penimbangan', 'sip_2.bayi_id', '=', 'sip2_penimbangan.bayi_id')
                        ->where('sip_2.posyandu_id', $posyandu_id)
                        ->where('sip2_penimbangan.bulan', $bulan)
                        ->where('sip2_penimbangan.tahun', $tahun)
                        ->whereNotNull('sip2_penimbangan.bb_hasil_penimbangan')
                        ->count();
                    
                    $ditimbangBalita = DB::table('sip_3')
                        ->join('sip3_penimbangan', 'sip_3.balita_id', '=', 'sip3_penimbangan.balita_id')
                        ->where('sip_3.posyandu_id', $posyandu_id)
                        ->where('sip3_penimbangan.bulan', $bulan)
                        ->where('sip3_penimbangan.tahun', $tahun)
                        ->whereNotNull('sip3_penimbangan.bb_hasil_penimbangan')
                        ->count();
                    
                    $ditimbang = $ditimbangBayi + $ditimbangBalita;
                    
                    // Hitung Naik (N) - Yang naik berat badannya dibanding bulan sebelumnya
                    $prevBulan = $bulan - 1;
                    $prevTahun = $tahun;
                    if ($bulan == 1) {
                        $prevBulan = 12;
                        $prevTahun = $tahun - 1;
                    }
                    
                    // Naik BB untuk bayi
                    $naikBayi = DB::table('sip_2')
                        ->join('sip2_penimbangan as curr', 'sip_2.bayi_id', '=', 'curr.bayi_id')
                        ->join('sip2_penimbangan as prev', 'sip_2.bayi_id', '=', 'prev.bayi_id')
                        ->where('sip_2.posyandu_id', $posyandu_id)
                        ->where('curr.bulan', $bulan)
                        ->where('curr.tahun', $tahun)
                        ->where('prev.bulan', $prevBulan)
                        ->where('prev.tahun', $prevTahun)
                        ->whereRaw('curr.bb_hasil_penimbangan > prev.bb_hasil_penimbangan')
                        ->count();
                    
                    // Naik BB untuk balita
                    $naikBalita = DB::table('sip_3')
                        ->join('sip3_penimbangan as curr', 'sip_3.balita_id', '=', 'curr.balita_id')
                        ->join('sip3_penimbangan as prev', 'sip_3.balita_id', '=', 'prev.balita_id')
                        ->where('sip_3.posyandu_id', $posyandu_id)
                        ->where('curr.bulan', $bulan)
                        ->where('curr.tahun', $tahun)
                        ->where('prev.bulan', $prevBulan)
                        ->where('prev.tahun', $prevTahun)
                        ->whereRaw('curr.bb_hasil_penimbangan > prev.bb_hasil_penimbangan')
                        ->count();
                    
                    $naik = $naikBayi + $naikBalita;
                    
                    // Accumulate data
                    $totalSasaran += $sasaran;
                    $totalKartu += $kartu;
                    $totalDitimbang += $ditimbang;
                    $totalNaik += $naik;
                }
                
                // Store monthly totals
                $dataS[] = $totalSasaran;
                $dataK[] = $totalKartu;
                $dataD[] = $totalDitimbang;
                $dataN[] = $totalNaik;
            }
            
            // Calculate percentages
            $persenK = [];
            $persenD = [];
            $persenN = [];
            
            for ($i = 0; $i < 12; $i++) {
                $s = $dataS[$i] ?: 1; // Avoid division by zero
                $persenK[] = round(($dataK[$i] / $s) * 100, 1);
                $persenD[] = round(($dataD[$i] / $s) * 100, 1);
                $persenN[] = round(($dataN[$i] / $s) * 100, 1);
            }
            
            return compact('labels', 'dataS', 'dataK', 'dataD', 'dataN', 'persenK', 'persenD', 'persenN');
            
        } catch (\Exception $e) {
            // Return empty data on error
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $emptyData = array_fill(0, 12, 0);
            
            return [
                'labels' => $labels,
                'dataS' => $emptyData,
                'dataK' => $emptyData,
                'dataD' => $emptyData,
                'dataN' => $emptyData,
                'persenK' => $emptyData,
                'persenD' => $emptyData,
                'persenN' => $emptyData
            ];
        }
    }
}
