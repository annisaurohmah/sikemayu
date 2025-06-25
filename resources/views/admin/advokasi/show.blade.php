@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Daftar Advokasi</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Advokasi</li>
        <li class="breadcrumb-item active">Advokasi Hari Ini</li>
    </ol>
</div>
@endsection

@section('button')
@endsection

@section('content')
@include('includes.flash')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title capitalize">Data Advokasi</h4>
                @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'kepatuhan_internal')
                <form class="mb-2" action="{{ route('show.advokasi') }}" method="GET">
                    <label for="date">Pilih Tanggal:</label>
                    <input type="date" id="date" name="date" value="{{ request('date', now()->toDateString()) }}">
                    <button type="submit" class="btn btn-secondary">Lihat Presensi</button>
                </form>

                
                @endif

                <!-- Form untuk menyimpan data presensi -->
                <form action="{{ route('update.advokasi') }}" method="POST">
                    @csrf
                    <div class="table-responsive">

                        <table id="datatable-buttons" class="table table-hover table-striped table-bordered nowrap" style="width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Flat</th>
                                    <th>Kamar</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                    <th>Advokasi</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absentMahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->name }}</td>
                                    <td>{{ $mahasiswa->flat_name }}</td>
                                    <td>{{ $mahasiswa->kamar }}</td>
                                    <td> {{ ucwords(str_replace('_', ' ', $mahasiswa->activity_name)) }}</td>
                                    <td>{{ $mahasiswa->status }}</td>
                                    <td>
                                        <!-- Set input as array to handle multiple entries -->
                                        <input type="hidden" name="attendance_ids[]" value="{{ $mahasiswa->attendance_id }}">
                                        <input type="text" name="advokasis[]" value="{{ $mahasiswa->advokasi }}" class="form-control">
                                        <span hidden> {{  $mahasiswa->advokasi }}</span>
                                    </td>
                                    <td>{{ $mahasiswa->updated }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<!-- Responsive-table-->

@endsection