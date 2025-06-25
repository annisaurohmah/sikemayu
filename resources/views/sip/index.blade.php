@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Sistem Informasi Posyandu {{ $posyandu->nama_posyandu }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">SIP</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $posyandu->nama_posyandu }}</a></li>

    </ol>
</div>
@endsection
@section('button')
<!-- <a href="/import" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Import Mahasiswa</a> -->
<form class="mt-1" action="" method="POST">
    @csrf
    @method('DELETE')
    <!-- <button type="submit" onclick="alert('Anda yakin menghapus seluruh data?')" class="btn btn-danger btn-sm btn-flat"><i class="mdi mdi-trash-can mr-2"></i>Hapus Semua Mahasiswa</button> -->
</form>
@endsection

@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">
        <div class="mt-2">

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="dataTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="format1-tab" data-toggle="tab" href="#format1" role="tab" aria-controls="format1" aria-selected="true">Format 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format2-tab" data-toggle="tab" href="#format2" role="tab" aria-controls="format2" aria-selected="false">Format 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format3-tab" data-toggle="tab" href="#format3" role="tab" aria-controls="format3" aria-selected="false">Format 3</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format4-tab" data-toggle="tab" href="#format4" role="tab" aria-controls="format4" aria-selected="false">Format 4</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format5-tab" data-toggle="tab" href="#format5" role="tab" aria-controls="format5" aria-selected="false">Format 5</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format6-tab" data-toggle="tab" href="#format6" role="tab" aria-controls="format6" aria-selected="false">Format 6</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="format7-tab" data-toggle="tab" href="#format7" role="tab" aria-controls="format7" aria-selected="false">Format 7</a>
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
            </div>
        </div>
        <!-- Log on to codeastro.com for more projects! -->
    </div> <!-- end col -->
</div> <!-- end row -->






@endsection


@section('script')

@endsection