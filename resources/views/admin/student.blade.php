@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Daftar Mahasiswa untuk Semester: {{ $currentSemester->semester_name }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Mahasiswa</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Mahasiswa</a>
<a href="/import" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Import Mahasiswa</a>
<form class="mt-1" action="{{ route('delete.all') }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="alert('Anda yakin menghapus seluruh data?')" class="btn btn-danger btn-sm btn-flat"><i class="mdi mdi-trash-can mr-2"></i>Hapus Semua Mahasiswa</button>
</form>
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
                                <th data-priority="1">NIM</th>
                                <th data-priority="2">Nama</th>
                                <th data-priority="3">Agama</th>
                                <th data-priority="4">Provinsi</th>
                                <th data-priority="5">Status</th>
                                <th data-priority="6">Prodi</th>
                                <th data-priority="7">Flat</th>
                                <th data-priority="8">Kamar</th>
                                <th data-priority="9">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $students as $student)

                            <tr>
                                <td>{{$student->nim}}</td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->religion}}</td>
                                <td>{{$student->province}}</td>
                                <td>{{$student->status}}</td>
                                <td>{{$student->prodi}}</td>
                                <td>{{$student->flat_name}}</td>
                                <td>{{$student->kamar}}</td>
                                <td>
                                    <a href="#edit{{$student->nim}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$student->mahasiswa_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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




@include('includes.add_student')


@foreach($students as $student)
@include('includes.edit_delete_student')
@endforeach

@endsection


@section('script')
<!-- Responsive-table-->

@endsection