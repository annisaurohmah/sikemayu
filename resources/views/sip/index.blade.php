@extends('layouts.master')

@section('css')
<!-- Select2 CSS -->
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid rgb(208, 219, 229);
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-rendered {
        line-height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-arrow {
        height: 36px;
    }

    /* CSS untuk Chart Dashboard */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .chart-container canvas {
        max-height: 100%;
        max-width: 100%;
    }

    @media (max-width: 768px) {
        .chart-container {
            height: 250px;
        }
    }
</style>
@endsection


@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Sistem Informasi Posyandu Desa Pangalengan</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">SIP</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $posyandu->nama_posyandu ?? 'Posyandu' }}</a></li>
    </ol>
</div>
@endsection


@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">

        <div class="container mt-2">

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-toggle="tab" href="#dashboard">Dashboard</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format1">Format 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format2">Format 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format3">Format 3</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format4">Format 4</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format5">Format 5</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format6">Format 6</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format7">Format 7</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#dokum">Dokumentasi</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-2" id="dataTabsContent">
                @include('sip.dashboard')
                @include('sip.format1')
                @include('sip.format2')
                @include('sip.format3')
                @include('sip.format4')
                @include('sip.format5')
                @include('sip.format6')
                @include('sip.format7')
                @include('sip.dokum')
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@include('sip.add_data_format1')
@include('sip.add_data_format2')
@include('sip.add_data_format3')
@include('sip.add_data_format4')
@include('sip.add_data_format5')
@include('sip.add_data_format6')
@include('sip.add_data_format7')
@include('sip.add_data_dokum')



@endsection


@section('script')
<!-- Select2 JS -->
<!-- Chart.js CDN untuk Dashboard SKDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Check if there's an active tab from session
        @if(session('activeTab'))
            var activeTab = '{{ session('activeTab') }}';
            console.log('Activating tab from session:', activeTab);
            
            // Remove active class from all tabs and content
            $('.nav-tabs .nav-link').removeClass('active');
            $('.tab-content .tab-pane').removeClass('show active');
            
            // Activate the specific tab
            $('a[href="#' + activeTab + '"]').addClass('active');
            $('#' + activeTab).addClass('show active');
        @endif

        // Initialize DataTables
        $('#table-format1').DataTable({
            responsive: true
        });
        $('#table-format2').DataTable({
            responsive: true
        });
        $('#table-format3').DataTable({
            responsive: true
        });
        $('#table-format4').DataTable({
            responsive: true
        });
        $('#table-format5').DataTable({
            responsive: true
        });
        $('#table-format6').DataTable({
            responsive: true
        });
        $('#table-format7').DataTable({
            responsive: true
        });
        $('#table-dokum').DataTable({
            responsive: true
        });

        // Initialize Select2 for searchable dropdowns
        $('.select2').select2({
            placeholder: "Pilih atau ketik untuk mencari...",
            allowClear: true,
            width: '100%'
        });

        // Debug: Check modal ketersediaan
        $('a[data-toggle="modal"]').on('click', function() {
            const targetModal = $(this).attr('href');
            console.log('Modal button clicked, target:', targetModal);

            if ($(targetModal).length === 0) {
                console.error('Modal not found in DOM:', targetModal);
            } else {
                console.log('Modal found in DOM:', targetModal);
            }
        });

        // Initialize Charts Dashboard SKDN setelah DOM ready
        initDashboardCharts();

        // Re-initialize chart saat tab dashboard diklik karena chart di tab tersembunyi tidak ter-render dengan benar
        $('a[href="#dashboard"]').on('shown.bs.tab', function() {
            // Delay sedikit untuk memastikan tab sudah sepenuhnya visible
            setTimeout(function() {
                initDashboardCharts();
            }, 100);
        });
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
        $($.fn.dataTable.tables({
                visible: true,
                api: true
            }))
            .DataTable()
            .columns.adjust()
            .responsive.recalc();
    });

    // Function untuk inisialisasi Chart Dashboard SKDN
    function initDashboardCharts() {
        // Cek apakah Chart.js sudah dimuat
        if (typeof Chart === 'undefined') {
            console.error('Chart.js tidak ditemukan. Pastikan CDN sudah dimuat.');
            return;
        }

        // Chart SKDN utama dengan data dari controller
        const skdnCtx = document.getElementById('skdnChart');
        if (skdnCtx) {
            // Cek apakah data tersedia
            const labels = @json($labels ?? []);
            const dataS = @json($dataS ?? []);
            const dataK = @json($dataK ?? []);
            const dataD = @json($dataD ?? []);
            const dataN = @json($dataN ?? []);

            if (labels.length === 0) {
                console.warn('Data chart SKDN kosong');
                return;
            }

            new Chart(skdnCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Sasaran (S)',
                            data: dataS,
                            backgroundColor: 'rgba(220, 53, 69, 0.8)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Punya Buku (K)',
                            data: dataK,
                            backgroundColor: 'rgba(255, 206, 86, 0.7)',
                            borderColor: 'rgba(255, 206, 86, 1)',

                            borderWidth: 1
                        },
                        {
                            label: 'Ditimbang (D)',
                            data: dataD,
                            backgroundColor: 'rgba(84, 213, 87, 0.7)',
                            borderColor: 'rgb(75, 192, 89)',
                            borderWidth: 1
                        },
                        {
                            label: 'Naik BB (N)',
                            data: dataN,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y} anak`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Dashboard Balok SKDN - Data Real',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Anak'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Periode'
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0,
                                font: {
                                    size: 10
                                },
                                maxTicksLimit: 12 // Limit jumlah label untuk menghindari tumpang tindih
                            }
                        }
                    },
                    elements: {
                        bar: {
                            borderRadius: 2
                        }
                    }
                }
            });
        } else {
            console.warn('Element skdnChart tidak ditemukan');
        }

        // Chart Status Gizi
        const statusGiziCtx = document.getElementById('statusGiziChart');
        if (statusGiziCtx) {
            new Chart(statusGiziCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Gizi Baik', 'Gizi Kurang', 'BGM', 'Gizi Lebih'],
                    datasets: [{
                        data: [70, 20, 8, 2], // Persentase contoh
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)', // Hijau - Gizi Baik
                            'rgba(255, 193, 7, 0.8)', // Kuning - Gizi Kurang
                            'rgba(220, 53, 69, 0.8)', // Merah - BGM
                            'rgba(23, 162, 184, 0.8)' // Biru - Gizi Lebih
                        ],
                        borderWidth: 2
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

        // Chart Cakupan Imunisasi
        const imunisasiCtx = document.getElementById('imunisasiChart');
        if (imunisasiCtx) {
            new Chart(imunisasiCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                            label: 'BCG',
                            data: [88, 90, 85, 92, 89, 94, 91, 96, 93, 95, 90, 97],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            tension: 0.4
                        },
                        {
                            label: 'DPT-HB',
                            data: [85, 87, 82, 89, 86, 91, 88, 93, 90, 92, 87, 94],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.4
                        },
                        {
                            label: 'Campak',
                            data: [82, 84, 79, 86, 83, 88, 85, 90, 87, 89, 84, 91],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }

        console.log('Dashboard SKDN charts berhasil dimuat!');
        
        // Hitung dan tampilkan persentase SKDN
        calculateSKDNPercentages();
    }
    
    // Fungsi untuk menghitung dan menampilkan persentase SKDN per bulan
    function calculateSKDNPercentages() {
        const dataS = @json($dataS ?? []);
        const dataK = @json($dataK ?? []);
        const dataD = @json($dataD ?? []);
        const dataN = @json($dataN ?? []);
        const labels = @json($labels ?? []);
        
        if (dataS.length === 0) {
            console.warn('Data SKDN kosong, menggunakan nilai default 0%');
            updatePercentageCards(0, 0, 0);
            return;
        }
        
        // Hitung total akumulatif untuk seluruh periode dalam tahun
        let totalS = 0, totalK = 0, totalD = 0, totalN = 0;
        let validMonthsCount = 0;
        
        // Hitung persentase per bulan dan akumulasikan
        let monthlyPercentages = {
            liputan: [],
            partisipasi: [],
            keberhasilan: []
        };
        
        for (let i = 0; i < dataS.length; i++) {
            let S = dataS[i] || 0;
            let K = dataK[i] || 0;
            let D = dataD[i] || 0;
            let N = dataN[i] || 0;
            
            // Akumulasi total
            totalS += S;
            totalK += K;
            totalD += D;
            totalN += N;
            
            // Hitung persentase bulanan
            let monthlyLiputan = S > 0 ? (K / S) * 100 : 0;
            let monthlyPartisipasi = S > 0 ? (D / S) * 100 : 0;
            let monthlyKeberhasilan = D > 0 ? (N / D) * 100 : 0;
            
            monthlyPercentages.liputan.push(monthlyLiputan);
            monthlyPercentages.partisipasi.push(monthlyPartisipasi);
            monthlyPercentages.keberhasilan.push(monthlyKeberhasilan);
            
            if (S > 0) validMonthsCount++;
        }
        
        // Hitung rata-rata persentase tahunan berdasarkan total akumulatif
        let avgLiputanProgram = totalS > 0 ? Math.round((totalK / totalS) * 100) : 0;
        let avgPartisipasiMasyarakat = totalS > 0 ? Math.round((totalD / totalS) * 100) : 0;
        let avgKeberhasilanPenimbangan = totalD > 0 ? Math.round((totalN / totalD) * 100) : 0;
        
        // Update tampilan card
        updatePercentageCards(avgLiputanProgram, avgPartisipasiMasyarakat, avgKeberhasilanPenimbangan);
        
        // Update tabel breakdown bulanan
        updateMonthlyBreakdownTable(labels, dataS, dataK, dataD, dataN, monthlyPercentages);
        
        console.log('Persentase SKDN berhasil dihitung (Total Tahunan):', {
            'Total K/S': avgLiputanProgram + '%',
            'Total D/S': avgPartisipasiMasyarakat + '%', 
            'Total N/D': avgKeberhasilanPenimbangan + '%',
            'Total Bulan': validMonthsCount,
            'Data per Bulan': monthlyPercentages
        });
    }
    
    // Fungsi untuk mengupdate tabel breakdown bulanan
    function updateMonthlyBreakdownTable(labels, dataS, dataK, dataD, dataN, percentages) {
        const tbody = document.getElementById('monthlyTableBody');
        if (!tbody) return;
        
        tbody.innerHTML = ''; // Clear existing rows
        
        for (let i = 0; i < labels.length; i++) {
            const S = dataS[i] || 0;
            const K = dataK[i] || 0;
            const D = dataD[i] || 0;
            const N = dataN[i] || 0;
            
            const pctKS = percentages.liputan[i] ? percentages.liputan[i].toFixed(1) : '0.0';
            const pctDS = percentages.partisipasi[i] ? percentages.partisipasi[i].toFixed(1) : '0.0';
            const pctND = percentages.keberhasilan[i] ? percentages.keberhasilan[i].toFixed(1) : '0.0';
            
            const row = `
                <tr>
                    <td><strong>${labels[i]}</strong></td>
                    <td>${S}</td>
                    <td>${K}</td>
                    <td>${D}</td>
                    <td>${N}</td>
                    <td class="text-primary"><strong>${pctKS}%</strong></td>
                    <td class="text-success"><strong>${pctDS}%</strong></td>
                    <td class="text-warning"><strong>${pctND}%</strong></td>
                </tr>
            `;
            tbody.innerHTML += row;
        }
        
        // Tambahkan row total/rata-rata
        const totalS = dataS.reduce((sum, val) => sum + (val || 0), 0);
        const totalK = dataK.reduce((sum, val) => sum + (val || 0), 0);
        const totalD = dataD.reduce((sum, val) => sum + (val || 0), 0);
        const totalN = dataN.reduce((sum, val) => sum + (val || 0), 0);
        
        const totalPctKS = totalS > 0 ? ((totalK / totalS) * 100).toFixed(1) : '0.0';
        const totalPctDS = totalS > 0 ? ((totalD / totalS) * 100).toFixed(1) : '0.0';
        const totalPctND = totalD > 0 ? ((totalN / totalD) * 100).toFixed(1) : '0.0';
        
        const totalRow = `
            <tr class="table-dark">
                <td><strong>TOTAL</strong></td>
                <td><strong>${totalS}</strong></td>
                <td><strong>${totalK}</strong></td>
                <td><strong>${totalD}</strong></td>
                <td><strong>${totalN}</strong></td>
                <td class="text-primary"><strong>${totalPctKS}%</strong></td>
                <td class="text-success"><strong>${totalPctDS}%</strong></td>
                <td class="text-warning"><strong>${totalPctND}%</strong></td>
            </tr>
        `;
        tbody.innerHTML += totalRow;
    }
    
    // Fungsi untuk mengupdate tampilan card persentase
    function updatePercentageCards(liputan, partisipasi, keberhasilan) {
        // Update nilai persentase
        const liputanEl = document.getElementById('liputanProgram');
        const partisipasiEl = document.getElementById('partisipasiMasyarakat');
        const keberhasilanEl = document.getElementById('keberhasilanPenimbangan');
        
        if (liputanEl) liputanEl.textContent = liputan + '%';
        if (partisipasiEl) partisipasiEl.textContent = partisipasi + '%';
        if (keberhasilanEl) keberhasilanEl.textContent = keberhasilan + '%';
    }
</script>

@endsection