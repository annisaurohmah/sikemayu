<!-- Tab Dashboard: Visualisasi Data Balok SKDN -->
<div class="tab-pane fade show active" id="dashboard" role="tabpanel">

    <div class="alert alert-info mt-2 mb-2">
        <i class="fa fa-bar-chart"></i> Dashboard Balok SKDN - Sistem Informasi Posyandu 
        <span class="badge badge-primary ml-2">Tahun: {{ request()->get('tahun', date('Y')) }}</span>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa fa-bar-chart"></i> 
                        Dashboard Balok SKDN - {{ $posyandu->nama_posyandu ?? 'Posyandu' }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Chart utama SKDN -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-center mb-4">Grafik Balok SKDN (Sasaran, Kartu, Ditimbang, Naik)</h6>
                            <div class="chart-container" style="height: 500px;">
                                <canvas id="skdnChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Persentase SKDN -->
                    <div class="row mt-4">
                        <div class="col-lg-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6>Tingkat Liputan Program</h6>
                                    <h4 id="liputanProgram">0%</h4>
                                    <small>K/S x 100</small>
                                    <div class="mt-2">
                                        <small>Kartu / Sasaran x 100</small>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-light"><i>Total akumulatif tahun {{ request()->get('tahun', date('Y')) }}</i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6>Tingkat Partisipasi Masyarakat</h6>
                                    <h4 id="partisipasiMasyarakat">0%</h4>
                                    <small>D/S x 100</small>
                                    <div class="mt-2">
                                        <small>Ditimbang / Sasaran x 100</small>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-light"><i>Total akumulatif tahun {{ request()->get('tahun', date('Y')) }}</i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h6>Tingkat Keberhasilan Penimbangan</h6>
                                    <h4 id="keberhasilanPenimbangan">0%</h4>
                                    <small>N/D x 100</small>
                                    <div class="mt-2">
                                        <small>Naik / Ditimbang x 100</small>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-light"><i>Total akumulatif tahun {{ request()->get('tahun', date('Y')) }}</i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Breakdown Persentase per Bulan -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fa fa-calendar"></i> 
                                        Detail Persentase SKDN per Bulan - Tahun {{ request()->get('tahun', date('Y')) }}
                                        <button class="btn btn-sm btn-outline-light float-right" type="button" data-toggle="collapse" data-target="#monthlyBreakdown" aria-expanded="false">
                                            <i class="fa fa-chevron-down"></i> Lihat Detail
                                        </button>
                                    </h6>
                                </div>
                                <div class="collapse" id="monthlyBreakdown">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped" id="monthlyPercentageTable">
                                                <thead>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Sasaran (S)</th>
                                                        <th>Kartu (K)</th>
                                                        <th>Ditimbang (D)</th>
                                                        <th>Naik (N)</th>
                                                        <th class="text-primary">K/S (%)</th>
                                                        <th class="text-success">D/S (%)</th>
                                                        <th class="text-warning">N/D (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="monthlyTableBody">
                                                    <!-- Data akan diisi oleh JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart tambahan
                    <div class="row mt-4">
                        <div class="col-lg-6 mb-4">
                            <h6 class="text-center">Status Gizi Balita</h6>
                            <div class="chart-container">
                                <canvas id="statusGiziChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mb-4">
                            <h6 class="text-center">Cakupan Imunisasi</h6>
                            <div class="chart-container">
                                <canvas id="imunisasiChart"></canvas>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
