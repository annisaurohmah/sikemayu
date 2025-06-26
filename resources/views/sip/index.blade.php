@extends('layouts.master')

@section('css')
@endsection


@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Catatan Dasawisma Desa Pangalengan</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">SIP</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $posyandu->nama_posyandu }}</a></li>
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
                    <a class="nav-link active" data-toggle="tab" href="#format1">Format 1</a>
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




@endsection


@section('script')

<script>
    $(document).ready(function() {
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