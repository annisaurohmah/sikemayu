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


@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">

        <div class="container mt-2">
            <div class="alert alert-info mt-2 mb-2">
                <i class="fa fa-table"></i> Data Dasawisma - Catatan Dasawisma Desa Pangalengan
                <span class="badge badge-primary ml-2">Tahun: {{ request()->get('tahun', date('Y')) }}</span>
            </div>
            
            <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>


            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-toggle="tab" href="#wilayah">Data Wilayah</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#keluarga">Anggota Keluarga</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#rumah">Kriteria Rumah, Air, & Makanan Pokok</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#kegiatan">Partisipasi Warga</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-2" id="dataTabsContent">

                <!-- Tab 1: Wilayah -->
                <div class="tab-pane fade show active table-responsive" id="wilayah" role="tabpanel">

                    <table id="table-wilayah" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">No</th>
                                <th data-priority="2">Nomor RW</th>
                                <th data-priority="3">Jumlah RT</th>
                                <th data-priority="4">Jumlah Dasawisma</th>
                                <th data-priority="5">Jumlah KRT</th>
                                <th data-priority="6">Jumlah KK</th>
                                <th data-priority="7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dasawisma->count() > 0)
                            @foreach($dasawisma as $data)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{$data->no_rw ?? '-'}}</td>
                                <td>{{$data->jumlah_RT ?? 0}}</td>
                                <td>{{$data->jumlah_DW ?? 0}}</td>
                                <td>{{$data->jumlah_KRT ?? 0}}</td>
                                <td>{{$data->jumlah_KK ?? 0}}</td>
                                <td>
                                    <a href="#edit{{$data->dw_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$data->dw_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th><strong>TOTAL</strong></th>
                                <th><strong>-</strong></th>
                                <th><strong>{{ $dasawisma->sum('jumlah_RT') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('jumlah_DW') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('jumlah_KRT') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('jumlah_KK') }}</strong></th>
                                <th><strong>-</strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Tab 2: Anggota Keluarga -->
                <div class="tab-pane fade table-responsive" id="keluarga" role="tabpanel">

                    <table id="table-keluarga" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th data-priority="1">No</th>
                                <th data-priority="2">Nomor RW</th>
                                <th data-priority="3">Total L</th>
                                <th data-priority="4">Total P</th>
                                <th data-priority="5">Balita L</th>
                                <th data-priority="6">Balita P</th>
                                <th data-priority="7">PUS</th>
                                <th data-priority="8">WUS</th>
                                <th data-priority="9">Ibu Hamil</th>
                                <th data-priority="10">Ibu Menyusui</th>
                                <th data-priority="11">Lansia</th>
                                <th data-priority="12">3 Buta L</th>
                                <th data-priority="13">3 Buta P</th>
                                <th data-priority="14">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dasawisma->count() > 0)
                            @foreach($dasawisma as $data)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{$data->no_rw ?? '-'}}</td>
                                <td>{{$data->total_L ?? 0}}</td>
                                <td>{{$data->total_P ?? 0}}</td>
                                <td>{{$data->balita_L ?? 0}}</td>
                                <td>{{$data->balita_P ?? 0}}</td>
                                <td>{{$data->PUS ?? 0}}</td>
                                <td>{{$data->WUS ?? 0}}</td>
                                <td>{{$data->ibu_hamil ?? 0}}</td>
                                <td>{{$data->ibu_menyusui ?? 0}}</td>
                                <td>{{$data->lansia ?? 0}}</td>
                                <td>{{$data->tiga_buta_L ?? 0}}</td>
                                <td>{{$data->tiga_buta_P ?? 0}}</td>
                                <td>
                                    <a href="#edit{{$data->dw_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$data->dw_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada data untuk ditampilkan</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th><strong>TOTAL</strong></th>
                                <th><strong>-</strong></th>
                                <th><strong>{{ $dasawisma->sum('total_L') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('total_P') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('balita_L') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('balita_P') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('PUS') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('WUS') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('ibu_hamil') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('ibu_menyusui') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('lansia') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('tiga_buta_L') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('tiga_buta_P') }}</strong></th>
                                <th><strong>-</strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Tab 3: Kriteria Rumah -->
                <div class="tab-pane fade table-responsive" id="rumah" role="tabpanel">

                    <table id="table-rumah" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                        <thead class="thead-dark">

                            <tr>
                                <th>No</th>
                                <th>Nomor RW</th>
                                <th>Sehat</th>
                                <th>Kurang Sehat</th>
                                <th>Pemb. Sampah</th>
                                <th>SPAL</th>
                                <th>Stiker P4K</th>
                                <th>PDAM</th>
                                <th>Sumur</th>
                                <th>Sungai</th>
                                <th>Dll</th>
                                <th>Jamban Keluarga</th>
                                <th>Makanan Beras</th>
                                <th>Non Beras</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dasawisma->count() > 0)
                            @foreach($dasawisma as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->no_rw ?? '-'}}</td>
                                <td>{{$data->sehat ?? 0}}</td>
                                <td>{{$data->krg_sehat ?? 0}}</td>
                                <td>{{$data->tempat_sampah ?? 0}}</td>
                                <td>{{$data->spal ?? 0}}</td>
                                <td>{{$data->stiker_pak ?? 0}}</td>
                                <td>{{$data->pdam ?? 0}}</td>
                                <td>{{$data->sumur ?? 0}}</td>
                                <td>{{$data->sungai ?? 0}}</td>
                                <td>{{$data->dll ?? 0}}</td>
                                <td>{{$data->jumlah_jamban ?? 0}}</td>
                                <td>{{$data->beras ?? 0}}</td>
                                <td>{{$data->non_beras ?? 0}}</td>
                                <td>
                                    <a href="#edit{{$data->dw_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$data->dw_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="15" class="text-center">Tidak ada data untuk ditampilkan</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th><strong>TOTAL</strong></th>
                                <th><strong>-</strong></th>
                                <th><strong>{{ $dasawisma->sum('sehat') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('krg_sehat') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('tempat_sampah') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('spal') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('stiker_pak') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('pdam') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('sumur') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('sungai') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('dll') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('jumlah_jamban') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('beras') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('non_beras') }}</strong></th>
                                <th><strong>-</strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Tab 4: Kegiatan Warga -->
                <div class="tab-pane fade table-responsive" id="kegiatan" role="tabpanel">

                    <table id="table-kegiatan" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nomor RW</th>
                                <th>UP2K</th>
                                <th>Pemanfaatan Tanah Pekarangan</th>
                                <th>Industri Rumah Tangga</th>
                                <th>Kesehatan Lingkungan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dasawisma->count() > 0)
                            @foreach($dasawisma as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->no_rw ?? '-'}}</td>
                                <td>{{ $data->up2k ?? 0 }}</td>
                                <td>{{$data->tanah_pkrgn ?? 0}}</td>
                                <td>{{$data->industri_rt ?? 0}}</td>
                                <td>{{$data->kesling ?? 0}}</td>
                                <td>{{$data->keterangan ?? '-'}}</td>
                                <td>
                                    <a href="#edit{{$data->dw_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                    <a href="#delete{{$data->dw_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data untuk ditampilkan</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th><strong>TOTAL</strong></th>
                                <th><strong>-</strong></th>
                                <th><strong>{{ $dasawisma->sum('up2k') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('tanah_pkrgn') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('industri_rt') }}</strong></th>
                                <th><strong>{{ $dasawisma->sum('kesling') }}</strong></th>
                                <th><strong>-</strong></th>
                                <th><strong>-</strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    @endsection

    @include('dasawisma.add_dasawisma')

    @if($dasawisma->count() > 0)
    @foreach($dasawisma as $item)
    @include('dasawisma.edit_delete_dasawisma', ['data' => $item])
    @endforeach
    @endif



    @section('script')

    <script>
        $(document).ready(function() {
            $('#table-wilayah').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                order: []
            });
            $('#table-keluarga').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                order: []
            });
            $('#table-rumah').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                order: []
            });
            $('#table-kegiatan').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                order: []
            });
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
            $($.fn.dataTable.tables({
                    visible: true,
                    api: true
                }))
                .DataTable()
                .columns.adjust()
                .responsive.recalc();
        });
    </script>


    @endsection