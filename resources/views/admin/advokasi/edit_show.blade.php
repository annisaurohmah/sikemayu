@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Presensi Advokasi</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('show.advokasi') }}"></a></li>
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
                <h4 class="header-title capitalize">Presensi Advokasi Hari Ini</h4>
                <!-- Form untuk menyimpan data presensi -->
                <form action="{{ route('update.advokasi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->schedule_id }}">
                    <table id="datatable-buttons" class="table table-hover table-striped table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Flat</th>
                                <th>Presensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->name }}</td>
                                <td>{{ $mahasiswa->flat_name }}</td>
                                <td class="row ml-1" style="display: flex; gap: 8px;">
                                    @if($activity == 'kerohanian_islam_isya' || $activity == 'kerohanian_islam_maghrib' || $activity == 'kerohanian_islam_subuh')
                                    @foreach(['Hadir', 'Izin', 'Sakit', 'Alpha', 'Haid', 'Terlambat'] as $status)
                                    <div class="form-check">
                                        <?php
                                        $check_attd = isset($attendances[$mahasiswa->mahasiswa_id]) && $attendances[$mahasiswa->mahasiswa_id] == $status;
                                        ?>
                                        <input class="form-check-input" type="radio" name="attendance[{{ $mahasiswa->mahasiswa_id }}]" id="{{ $status }}_{{ $mahasiswa->mahasiswa_id }}" value="{{ $status }}"
                                            @if ($check_attd) checked @endif>
                                        <label class="form-check-label" for="{{ $status }}_{{ $mahasiswa->mahasiswa_id }}">{{ ucfirst($status) }}</label>
                                    </div>
                                    @endforeach
                                    @else
                                    @foreach(['Hadir', 'Izin', 'Sakit', 'Alpha', 'Terlambat'] as $status)
                                    <div class="form-check">
                                        <?php
                                        $check_attd = isset($attendances[$mahasiswa->mahasiswa_id]) && $attendances[$mahasiswa->mahasiswa_id] == $status;
                                        ?>
                                        <input class="form-check-input" type="radio" name="attendance[{{ $mahasiswa->mahasiswa_id }}]" id="{{ $status }}_{{ $mahasiswa->mahasiswa_id }}" value="{{ $status }}"
                                            @if ($check_attd) checked @endif>
                                        <label class="form-check-label" for="{{ $status }}_{{ $mahasiswa->mahasiswa_id }}">{{ ucfirst($status) }}</label>
                                    </div>
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tombol simpan presensi -->
                    <button type="submit" class="btn btn-success">Simpan Presensi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<!-- Responsive-table-->

@endsection