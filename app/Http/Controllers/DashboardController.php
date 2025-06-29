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

class DashboardController extends Controller
{
    use HasDataAccess;
    
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
                $stats['total_bayi'] = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) <= 12')->count();
                $stats['total_balita'] = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) > 12 AND TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) <= 5')->count();
            } else {
                $stats['total_penduduk'] = 0;
                $stats['total_bayi'] = 0;
                $stats['total_balita'] = 0;
            }
            
            // Dasawisma data
            if ($access['can_access_all'] || $access['can_access_rw_only']) {
                try {
                    $dwQuery = Dw::where('tahun', $tahun);
                    if ($access['can_access_rw_only']) {
                        try {
                            $dwQuery->whereHas('rw', function($q) use ($access) {
                                $q->where('no_rw', $access['rw']);
                            });
                        } catch (\Exception $e) {
                            // If relationship doesn't work, try direct join
                            $dwQuery = Dw::join('rw', 'rw.rw_id', '=', 'dw.rw_id')
                                     ->where('dw.tahun', $tahun)
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
            
            // SIP data
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
                'bayi' => Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) <= 12')->count(),
                'balita' => Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, NOW()) > 12 AND TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) <= 5')->count(),
                'anak' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, NOW()) BETWEEN 6 AND 17')->count(),
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
}
