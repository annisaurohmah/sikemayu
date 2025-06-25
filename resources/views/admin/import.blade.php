@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Import Data Mahasiswa</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Daftar Mahasiswa</a></li>

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
                <p>Silakan download <span style="font-weight: bold; color: blue;"><a href="{{ asset('templates/template_mahasiswa.xlsx') }}">template Excel</a></span> dan isi dengan data mahasiswa yang akan diimport.</p>

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

                <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="file">Pilih file Excel:</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required>

                    <button type="submit">Import</button>
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