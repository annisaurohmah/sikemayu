@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Data Bayi</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Data Bayi</a></li>

    </ol>
</div>
@endsection
@section('button')
<!-- <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Data Bayi</a>
<a href="/import" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Import Data Bayi</a>
<form class="mt-1" action="" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="alert('Anda yakin menghapus seluruh data?')" class="btn btn-danger btn-sm btn-flat"><i class="mdi mdi-trash-can mr-2"></i>Hapus Semua Mahasiswa</button>
</form> -->
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>
@endsection

@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Log on to codeastro.com for more projects! -->
                    <table id="datatable-buttons" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">No</th>
                                <th data-priority="2">NIK</th>
                                <th data-priority="3">Nama Lengkap</th>
                                <th data-priority="4">Jenis Kelamin</th>
                                <th data-priority="5">Tanggal Lahir</th>
                                <th data-priority="6">Umur</th>
                                <th data-priority="7">Nama Lengkap Orang Tua</th>
                                <th data-priority="8">Jenis Kelamin Ortu</th>
                                <th data-priority="9">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $bayi as $bayi_item)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$bayi_item->nik}}</td>
                                <td>{{$bayi_item->nama_lengkap}}</td>
                                <td>{{$bayi_item->jenis_kelamin}}</td>
                                <td>{{$bayi_item->tanggal_lahir ? $bayi_item->tanggal_lahir->format('d-m-Y') : ''}}</td>
                                <td>
                                    @if($bayi_item->tanggal_lahir)
                                        @php
                                            $birthDate = $bayi_item->tanggal_lahir;
                                            $today = \Carbon\Carbon::now();
                                            $diffDays = $today->diffInDays($birthDate);
                                            $years = floor($diffDays / 365);
                                            $months = floor(($diffDays % 365) / 30);
                                            $days = floor(($diffDays % 365) % 30);
                                            
                                            $ageText = '';
                                            if ($years > 0) $ageText .= $years . ' tahun ';
                                            if ($months > 0) $ageText .= $months . ' bulan ';
                                            if ($days > 0 && $years === 0) $ageText .= $days . ' hari';
                                            if ($ageText === '') $ageText = '0 hari';
                                        @endphp
                                        {{ trim($ageText) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{$bayi_item->nama_lengkap_ortu}}</td>
                                <td>{{$bayi_item->jenis_kelamin_ortu}}</td>
                                <td>
                                    <a href="#edit{{$bayi_item->nik}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$bayi_item->nik}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Log on to codeastro.com for more projects! -->
</div>
</div> <!-- end col -->
</div> <!-- end row -->




@endsection


@section('script')
<!-- Responsive-table-->

@endsection

@include('includes.add_data_bayi')
@foreach($bayi as $bayi_item)
    @include('includes.edit_delete_bayi', ['bayi' => $bayi_item])
@endforeach