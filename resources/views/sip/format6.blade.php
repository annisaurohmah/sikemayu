<!-- Tab 6: Format 6 -->
<div class="tab-pane fade table-responsive" id="format6" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format6" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Bulan</th>
                <th rowspan="2">Bayi 0-12 bulan</th>
                <th rowspan="2">Balita 1-5 tahun</th>
                <th rowspan="2">WUS</th>
                <th colspan="3" class="text-center">Ibu</th>
                <th colspan="2" class="text-center">Jumlah Bayi </th>
                <th colspan="2" class="text-center">Jumlah Kematian </th>
                <th colspan="4" class="text-center">Jumlah Petugas yang </th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>PUS</th>
                <th>Hamil</th>
                <th>Menyusui</th>

                <th>Lahir</th>
                <th>Meninggal</th>

                <th>Ibu Hamil</th>
                <th>Melahirkan</th>

                <th>Nifas</th>
                <th>Kader Posyandu</th>
                <th>PLKB</th>
                <th>Medis & Paramedis</th>
            </tr>
        </thead>
        <tbody>
            @if($sip6 && $sip6->count() > 0)
            @foreach($sip6 as $rekap)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ strtoupper(\Carbon\Carbon::create()->month($rekap->bulan)->translatedFormat('F')) }}</td>
                <td>{{ $rekap->bayi_0_12_bulan }}</td>
                <td>{{ $rekap->balita_1_5_tahun }}</td>
                <td>{{ $rekap->jumlah_wus}}</td>
                <td>{{ $rekap->jumlah_pus }}</td>
                <td>{{ $rekap->jumlah_hamil }}</td>
                <td>{{ $rekap->jumlah_menyusui }}</td>
                <td>{{ $rekap->bayi_lahir ?? 0 }}</td>
                <td>{{ $rekap->bayi_meninggal ?? 0 }}</td>
                <td>{{ $rekap->ibu_hamil_meninggal }}</td>
                <td>{{ $rekap->ibu_melahirkan_meninggal }}</td>
                <td>{{ $rekap->nifas }}</td>
                <td>{{ $rekap->kader_posyandu }}</td>
                <td>{{ $rekap->plkb }}</td>
                <td>{{ $rekap->medis_paramedis }}</td>
                <td>{{ $rekap->keterangan }}</td>
                <td>
                    <a href="#edit{{$rekap->id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#delete{{$rekap->id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                </td>

            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="17" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>