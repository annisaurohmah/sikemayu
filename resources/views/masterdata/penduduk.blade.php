@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Data Penduduk</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Data Penduduk</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Data Penduduk</a>
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
                                <th data-priority="3">No KK</th>
                                <th data-priority="4">Nama Lengkap</th>
                                <th data-priority="5">Jenis Kelamin</th>
                                <th data-priority="6">Tanggal Lahir</th>
                                <th data-priority="7">SHDK</th>
                                <th data-priority="8">BPJS</th>
                                <th data-priority="9">Faskes</th>
                                <th data-priority="10">Pendidikan</th>
                                <th data-priority="11">Pekerjaan</th>
                                <th data-priority="12">Alamat</th>
                                <th data-priority="13">RT</th>
                                <th data-priority="14">RW</th>
                                <th data-priority="15">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $penduduk as $penduduk_item)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$penduduk_item->nik}}</td>
                                <td>{{$penduduk_item->no_kk}}</td>
                                <td>{{$penduduk_item->nama}}</td>
                                <td>{{$penduduk_item->jenis_kelamin}}</td>
                                <td>{{$penduduk_item->tanggal_lahir ? $penduduk_item->tanggal_lahir->format('d-m-Y') : ''}}</td>
                                <td>{{$penduduk_item->shdk}}</td>
                                <td>{{$penduduk_item->bpjs}}</td>
                                <td>{{$penduduk_item->faskes}}</td>
                                <td>{{$penduduk_item->pendidikan}}</td>
                                <td>{{$penduduk_item->pekerjaan}}</td>
                                <td>{{$penduduk_item->alamat}}</td>
                                <td>{{$penduduk_item->rt}}</td>
                                <td>{{$penduduk_item->rwData ? $penduduk_item->rwData->no_rw : $penduduk_item->rw}}</td>
                                <td>
                                    <a href="#edit{{$penduduk_item->nik}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$penduduk_item->nik}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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

@include('includes.add_data_penduduk')
@foreach($penduduk as $penduduk_item)
    @include('includes.edit_delete_penduduk', ['penduduk' => $penduduk_item, 'rw' => $rw])
@endforeach