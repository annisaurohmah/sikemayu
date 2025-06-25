@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Eksport Data Presensi</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Presensi</a></li>

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


                @if (session('error'))
                <div style="color: red;">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="GET" action="{{ route('export.excel') }}">
                    <label for="tanggal">Pilih Tanggal:</label>
                    <input class="form-control" type="date" id="tanggal" name="date" required>
                    <div class="form-group">
                            <label for="activity">Aktivitas</label>
                            <select class="form-control" id="activity" name="activity" required>
                                <option value="" selected>- Pilih -</option>
                                <option value="makan_apel">Makan dan Apel</option>
                                <option value="hindu">Kerohanian Islam</option>
                                <option value="protestan">Kerohanian Protestan</option>
                                <option value="katolik">KerohanianKatolik</option>
                                <option value="hindu_buddha">Kerohanian Hindu Buddha</option>
                            </select>
                        </div>
                    <button type="submit" class="btn btn-primary">Export Excel</button>
                </form>
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