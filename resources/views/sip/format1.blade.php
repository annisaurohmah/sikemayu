<!-- Tab 1: Format 1 -->
<div class="tab-pane fade show active table-responsive" id="format1" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format1" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th data-priority="1">No</th>
                <th data-priority="2">Tahun</th>
                <th data-priority="3">Bulan</th>
                <th data-priority="4">Nama Ibu</th>
                <th data-priority="5">Nama Bapak</th>
                <th data-priority="6">Nama Bayi</th>
                <th data-priority="7">Tanggal Lahir</th>
                <th data-priority="8">Tanggal Meninggal Bayi</th>
                <th data-priority="9">Tanggal Meninggal Ibu</th>
                <th data-priority="10">Keterangan</th>
                <th data-priority="11">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $format1 as $format1)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $format1->tahun }}</td>
                <td>{{$format1->bulan}}</td>
                <td>{{$format1->nama_ibu}}</td>
                <td>{{$format1->nama_bapak}}</td>
                <td>{{$format1->nama_bayi}}</td>
                <td>{{ \Carbon\Carbon::parse($format1->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{$format1->tgl_meninggal_ibu}}</td>
                <td>{{$format1->tgl_meninggal_bayi}}</td>
                <td>{{$format1->keterangan}}</td>
                <td>
                    <a href="#edit{{$format1->sip1_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#delete{{$format1->sip1_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>