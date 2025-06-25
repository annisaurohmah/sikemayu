@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Daftar Pengguna</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Pengguna</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Pengguna</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Pengguna</a>


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
                                <th data-priority="2">Nama Pengguna</th>
                                <th data-priority="3">Email</th>
                                <th data-priority="4">Role</th>
                                <th data-priority="5">Flat</th>
                                <th data-priority="6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user)

                            <tr>
                                <td>{{$user->user_id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email }}</td>
                                <td>{{$user->role }}</td>
                                <td>
                                    @if($user->role == 'super_admin' || $user->role == 'admin' || $user->role == 'guest' || $user->role == 'kepatuhan_internal' )
                                    All Flat
                                    @else
                                    {{ $user->flat_name ?? 'No Flat Assigned' }}
                                    @endif
                                </td>
                                <td>
                                    <a href="#edit{{$user->user_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$user->user_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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




@include('includes.add_user')

@foreach( $users as $user)
    @include('includes.edit_delete_user')
@endforeach

@endsection


@section('script')
<!-- Responsive-table-->

@endsection