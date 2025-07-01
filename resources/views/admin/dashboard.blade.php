@extends('layouts.master')

@section('css')
<!--Chartist Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('plugins/chartist/css/chartist.min.css') }}">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
.stat-card {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    border-radius: 15px;
    padding: 20px;
    color: #ffffff;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
}
.stat-number {
    font-size: 2.8rem;
    font-weight: 900;
    margin-bottom: 8px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    color: #ffffff;
    line-height: 1;
}
.stat-label {
    font-size: 1rem;
    font-weight: 600;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    color: #ffffff;
    letter-spacing: 0.5px;
}
.chart-container {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    margin-bottom: 30px;
    text-align: center;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}
.welcome-card h2 {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}
.welcome-card p {
    color: rgba(255,255,255,0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
.role-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: bold;
    margin-top: 15px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.admin-desa { 
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
    color: white; 
}
.admin-rw { 
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); 
    color: white; 
}
.admin-kader { 
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); 
    color: #333; 
    text-shadow: none;
}
</style>
@endsection

@section('breadcrumb')
<div class="col-sm-6 text-left">
    <h4 class="page-title">DASHBOARD</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Sistem Pelaporan Kegiatan PKK Desa Margaluyu</li>
    </ol>
</div>
<div class="col-sm-6 text-right">
    <div class="form-group">
        <select class="form-control" id="yearFilter" style="width: 120px; display: inline-block;">
            @for ($year = 2020; $year <= date('Y') + 1; $year++)
                <option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>{{ $year }}</option>
            @endfor
        </select>
    </div>
</div>
@endsection

@section('content')

<!-- Welcome Card -->
<div class="welcome-card">
    <h2>Selamat Datang, {{ Auth::user()->username }}!</h2>
    <p>Di Sistem Informasi Pelaporan Kegiatan PKK Desa Margaluyu</p>
    <span class="role-badge {{ str_replace('_', '-', $access['role']) }}">
        {{ ucwords(str_replace('_', ' ', $access['role'])) }}
        @if($access['can_access_rw_only'])
            - RW {{ $access['rw'] }}
        @elseif($access['can_access_posyandu_only'])
            - {{ $access['posyandu'] }}
        @endif
    </span>
</div>

<!-- Statistics Cards -->
<div class="row">
    @if($access['can_access_all'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    @endif
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #8b0000 0%, #4b0000 100%);">
            <div class="stat-number">{{ $stats['total_posyandu'] }}</div>
            <div class="stat-label">
                @if($access['can_access_all'])
                    Total Posyandu
                @else
                    Posyandu Saya
                @endif
            </div>
        </div>
    </div>
    
    @if($access['can_access_all'] || $access['can_access_rw_only'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #0f3460 0%, #2d5a87 100%);">
            <div class="stat-number">{{ $stats['total_rw'] }}</div>
            <div class="stat-label">
                @if($access['can_access_all'])
                    Total RW
                @else
                    RW Saya
                @endif
            </div>
        </div>
    </div>
    @endif
    
    @if($access['can_access_all'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #1b4332 0%, #2d5a3d 100%);">
            <div class="stat-number">{{ $stats['total_penduduk'] }}</div>
            <div class="stat-label">Total Penduduk</div>
        </div>
    </div>
    @endif
</div>

<!-- Additional Statistics Row -->
<div class="row">
    @if($access['can_access_all'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #5a189a 0%, #3c096c 100%);">
            <div class="stat-number">{{ $stats['total_bayi'] ?? 0 }}</div>
            <div class="stat-label">Total Bayi (0-11 bulan)</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #c77dff 0%, #9d4edd 100%);">
            <div class="stat-number">{{ $stats['total_balita'] ?? 0 }}</div>
            <div class="stat-label">Total Balita (12-59 bulan)</div>
        </div>
    </div>
    @endif
    
    @if($access['can_access_all'] || $access['can_access_rw_only'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #bc4749 0%, #8b2635 100%);">
            <div class="stat-number">{{ $stats['total_dasawisma'] ?? 0 }}</div>
            <div class="stat-label">
                @if($access['can_access_all'])
                    Total Dasawisma (Keseluruhan)
                @else
                    Total Dasawisma RW Saya
                @endif
            </div>
        </div>
    </div>
    @endif
    
    @if($access['can_access_all'] || $access['can_access_posyandu_only'])
    <div class="col-lg-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg, #144552 0%, #0f3460 100%);">
            <div class="stat-number">{{ ($stats['total_sip1'] ?? 0) + ($stats['total_sip2'] ?? 0) + ($stats['total_sip3'] ?? 0) }}</div>
            <div class="stat-label">
                @if($access['can_access_all'])
                    Total Data SIP (Keseluruhan)
                @else
                    Total Data SIP Posyandu Saya
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Charts Section -->
<div class="row">
    @if($access['can_access_all'] || $access['can_access_rw_only'])
    <div class="col-lg-6">
        <div class="chart-container">
            <h5 class="text-center mb-3">Data Dasawisma Bulanan {{ $tahun }}</h5>
            <div style="height: 300px;">
                <canvas id="dasawismaChart"></canvas>
            </div>
        </div>
    </div>
    @endif
    
    @if($access['can_access_all'] || $access['can_access_posyandu_only'])
    <div class="col-lg-6">
        <div class="chart-container">
            <h5 class="text-center mb-3">Data SIP Bulanan {{ $tahun }}</h5>
            <div style="height: 300px;">
                <canvas id="sipChart"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

@if($access['can_access_all'])
<div class="row">
    <div class="col-lg-6">
        <div class="chart-container">
            <h5 class="text-center mb-3">Distribusi Gender</h5>
            <div style="height: 300px;">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="chart-container">
            <h5 class="text-center mb-3">Distribusi Usia</h5>
            <div style="height: 300px;">
                <canvas id="ageChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endif


@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Year filter change
    document.getElementById('yearFilter').addEventListener('change', function() {
        window.location.href = '{{ route("dashboard") }}?tahun=' + this.value;
    });

    @if($access['can_access_all'] || $access['can_access_rw_only'])
    // Dasawisma Monthly Chart
    const dasawismaCtx = document.getElementById('dasawismaChart');
    if (dasawismaCtx) {
        new Chart(dasawismaCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($stats['monthly_data']['dasawisma'] ?? [])) !!},
                datasets: [{
                    label: 'Data Dasawisma',
                    data: {!! json_encode(array_values($stats['monthly_data']['dasawisma'] ?? [])) !!},
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    @endif

    @if($access['can_access_all'] || $access['can_access_posyandu_only'])
    // SIP Monthly Chart
    const sipCtx = document.getElementById('sipChart');
    if (sipCtx) {
        new Chart(sipCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($stats['monthly_data']['sip'] ?? [])) !!},
                datasets: [{
                    label: 'Data SIP',
                    data: {!! json_encode(array_values($stats['monthly_data']['sip'] ?? [])) !!},
                    backgroundColor: 'rgba(240, 147, 251, 0.8)',
                    borderColor: 'rgb(240, 147, 251)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    @endif

    @if($access['can_access_all'])
    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $stats['gender_data']['male'] }}, {{ $stats['gender_data']['female'] }}],
                    backgroundColor: ['#4facfe', '#f093fb'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Age Distribution Chart
    const ageCtx = document.getElementById('ageChart');
    if (ageCtx) {
        new Chart(ageCtx, {
            type: 'polarArea',
            data: {
                labels: ['Bayi', 'Balita', 'Anak', 'Dewasa', 'Lansia'],
                datasets: [{
                    data: [
                        {{ $stats['age_distribution']['bayi'] }},
                        {{ $stats['age_distribution']['balita'] }},
                        {{ $stats['age_distribution']['anak'] }},
                        {{ $stats['age_distribution']['dewasa'] }},
                        {{ $stats['age_distribution']['lansia'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 154, 158, 0.8)',
                        'rgba(168, 237, 234, 0.8)',
                        'rgba(255, 236, 210, 0.8)',
                        'rgba(161, 140, 209, 0.8)',
                        'rgba(67, 233, 123, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endsection