@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Daftar Semester</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Semester</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Semester</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Semester</a>


@endsection

@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="table-responsive">

                <!-- Log on to codeastro.com for more projects! -->
                <table id="datatable-buttons" class="table table-striped table-hover table-bordered display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead class="thead-dark">
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="2">Nama Semester</th>
                            <th data-priority="3">Tanggal Mulai</th>
                            <th data-priority="4">Tanggal Berakhir</th>
                            <th data-priority="5">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $semesters as $semester)

                        <tr>
                            <td>{{$semester->semester_id}}</td>
                            <td>{{$semester->semester_name}}</td>
                            <td>{{$semester->start_date}}</td>
                            <td>{{$semester->end_date }}</td>
                            <td>

                                <a href="#edit{{$semester->semester_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                <a href="#delete{{$semester->semester_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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




@include('includes.add_semester')

@foreach($semesters as $semester)
@include('includes.edit_delete_semester')
@endforeach

@endsection


@section('script')
<!-- Responsive-table-->

@endsection