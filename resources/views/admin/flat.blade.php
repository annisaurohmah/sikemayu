@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Daftar Flat</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Flat</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Flat</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Flat</a>


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
                                <th data-priority="1">ID</th>
                                <th data-priority="2">Nama Flat</th>
                                <th data-priority="3">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $flats as $flat)

                            <tr>
                                <td>{{$flat->flat_id}}</td>
                                <td>{{$flat->name}}</td>

                                <td>

                                    <a href="#edit{{$flat->flat_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    @include('includes.edit_delete_flat')
                                    <a href="#delete{{$flat->flat_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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




@include('includes.add_flat')
@endsection


@section('script')
<!-- Responsive-table-->

@endsection