@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Catatan Dasawisma Desa Pangalengan</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dasawisma</a></li>
    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>


@endsection

@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">

        <div class="container mt-2">
            <h5 class="mb-4">Laporan Data RW</h5>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="dataTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="wilayah-tab" data-bs-toggle="tab" data-bs-target="#wilayah" type="button" role="tab">Data Wilayah</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="keluarga-tab" data-bs-toggle="tab" data-bs-target="#keluarga" type="button" role="tab">Anggota Keluarga</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rumah-tab" data-bs-toggle="tab" data-bs-target="#rumah" type="button" role="tab">Kriteria Rumah, Air, & Makanan Pokok</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kegiatan-tab" data-bs-toggle="tab" data-bs-target="#kegiatan" type="button" role="tab">Partisipasi Warga</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-2" id="dataTabsContent">

                <!-- Tab 1: Wilayah -->
                <div class="tab-pane fade show active table-responsive" id="wilayah" role="tabpanel">
                    <table id="datatable-buttons" class="table table-sm table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">NO</th>
                                <th data-priority="2">NOMOR RW</th>
                                <th data-priority="3">JUML. RT</th>
                                <th data-priority="4">JUML. DASA WISMA</th>
                                <th data-priority="5">JUML. KRT</th>
                                <th data-priority="6">JUML. KK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>01</td>
                                <td>5</td>
                                <td>10</td>
                                <td>50</td>
                                <td>45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tab 2: Anggota Keluarga -->
                <div class="tab-pane fade table-responsive" id="keluarga" role="tabpanel">
                    <table id="datatable-buttons" class="table table-sm table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">No</th>
                                <th data-priority="2">Nomor RW</th>
                                <th data-priority="3">TOTAL L</th>
                                <th data-priority="4">TOTAL P</th>
                                <th data-priority="5">BALITA L</th>
                                <th data-priority="6">BALITA P</th>
                                <th data-priority="7">PUS</th>
                                <th data-priority="8">WUS</th>
                                <th data-priority="9">IBU HAMIL</th>
                                <th data-priority="10">IBU MENYUSUI</th>
                                <th data-priority="11">LANSIA</th>
                                <th data-priority="12">3 BUTA L</th>
                                <th data-priority="13w3">3 BUTA P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>01</td>
                                <td>30</td>
                                <td>25</td>
                                <td>10</td>
                                <td>8</td>
                                <td>5</td>
                                <td>3</td>
                                <td>2</td>
                                <td>1</td>
                                <td>5</td>
                                <td>2</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tab 3: Kriteria Rumah -->
                <div class="tab-pane fade table-responsive" id="rumah" role="tabpanel">
                    <table id="datatable-buttons" class="table table-sm table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nomor RW</th>
                                <th>SEHAT</th>
                                <th>KURANG SEHAT</th>
                                <th>PEMB. SAMPAH</th>
                                <th>SPAL</th>
                                <th>STIKER P4K</th>
                                <th>PDAM</th>
                                <th>SUMUR</th>
                                <th>SUNGAI</th>
                                <th>DLL</th>
                                <th>JAMBAN KELUARGA</th>
                                <th>MAKANAN BERAS</th>
                                <th>NON BERAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>01</td>
                                <td>2</td>
                                <td>4</td>
                                <td>6</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>4</td>
                                <td>2</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tab 4: Kegiatan Warga -->
                <div class="tab-pane fade table-responsive" id="kegiatan" role="tabpanel">
                    <table id="datatable-buttons" class="table table-sm table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nomor RW</th>
                                <th>UP2K</th>
                                <th>PEMANFAATAN TANAH PEKARANGAN</th>
                                <th>INDUSTRI RUMAH TANGGA</th>
                                <th>KESEHATAN LINGKUNGAN</th>
                                <th>KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>01</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>3</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->




@endsection


@section('script')
<!-- Responsive-table-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection