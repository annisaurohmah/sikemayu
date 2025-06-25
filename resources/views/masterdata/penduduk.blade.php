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
<!-- <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Data Bayi</a>
<a href="/import" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Import Data Bayi</a>
<form class="mt-1" action="" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="alert('Anda yakin menghapus seluruh data?')" class="btn btn-danger btn-sm btn-flat"><i class="mdi mdi-trash-can mr-2"></i>Hapus Semua Mahasiswa</button>
</form> -->
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
                            @foreach( $penduduk as $penduduk)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$penduduk->nik}}</td>
                                <td>{{$penduduk->no_kk}}</td>
                                <td>{{$penduduk->nama}}</td>
                                <td>{{$penduduk->tanggal_lahir}}</td>
                                <td>{{$penduduk->jenis_kelamin}}</td>
                                <td>{{$penduduk->shdk}}</td>
                                <td>{{$penduduk->bpjs}}</td>
                                <td>{{$penduduk->faskes}}</td>
                                <td>{{$penduduk->pendidikan}}</td>
                                <td>{{$penduduk->pekerjaan}}</td>
                                <td>{{$penduduk->alamat}}</td>
                                <td>{{$penduduk->rt}}</td>
                                <td>{{$penduduk->rw}}</td>
                                <td>
                                    <a href="#edit{{$penduduk->nik}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$penduduk->nik}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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

@endsection`