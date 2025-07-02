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
    <h4 class="page-title text-left"></h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Pokja</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Pokja I</a></li>
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
                    <a class="nav-link active" data-toggle="tab" href="#pokja1">Bidang Keagamaan dan Keterampilan</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#format1">Bidang Gotong Royong</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-2" id="dataTabsContent">
                @include('pokja.index')
                @include('pokja.index')
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@include('pokja.add_data_pokja1_agama')
@include('pokja.add_data_pokja1_gotong')



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
        $('#table-pokja').DataTable({
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

</script>

@endsection