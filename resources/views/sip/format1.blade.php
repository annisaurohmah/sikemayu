<!-- Tab 1: Format 1 -->
<div class="tab-pane fade show active table-responsive" id="format1" role="tabpanel">

    <a href="#addnewformat1" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

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
            @foreach( $format1 as $sip1)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $sip1->tahun }}</td>
                <td>{{$sip1->bulan}}</td>
                <td>{{$sip1->nama_ibu}}</td>
                <td>{{$sip1->nama_bapak}}</td>
                <td>{{$sip1->nama_bayi}}</td>
                <td>{{ $sip1->tgl_lahir ? $sip1->tgl_lahir->format('d-m-Y') : '-' }}</td>
                <td>{{ $sip1->tgl_meninggal_ibu ? $sip1->tgl_meninggal_ibu->format('d-m-Y') : '-' }}</td>
                <td>{{ $sip1->tgl_meninggal_bayi ? $sip1->tgl_meninggal_bayi->format('d-m-Y') : '-' }}</td>
                <td>{{$sip1->keterangan ?? '-'}}</td>
                <td>
                    <a href="#edit{{$sip1->sip1_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#delete{{$sip1->sip1_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            @include('sip.edit_delete_format1', ['sip1' => $sip1])
            @endforeach
        </tbody>
    </table>
</div>
