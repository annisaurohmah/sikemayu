<!-- Tab 4: Format 4 -->
<div class="tab-pane fade table-responsive" id="format4" role="tabpanel">

    <a href="#addnewformat4" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format4" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama WUS dan PUS</th>
                <th rowspan="2">Umur</th>
                <th rowspan="2">Nama Suami</th>
                <th rowspan="2">Tahapan KS</th>
                <th rowspan="2">Kelompok Dasawisma</th>
                <th colspan="2" class="text-center">Jumlah Anak</th>
                <th rowspan="2">Pengukuran LILA <= Atau> 23,5cm</th>
                <th colspan="5" class="text-center">Pemberian Imunisasi TT</th>
                <th rowspan="2">Jenis Kontrasepsi yang Dipakai</th>
                <th colspan="2" class="text-center">Penggantian</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Yang Hidup</th>
                <th>Meninggal pada Umur</th>
                @foreach(['I', 'II', 'III', 'IV', 'V'] as $imun)
                <th>{{ $imun }}</th>
                @endforeach
                <th>Tanggal/Bulan</th>
                <th>Jenis Kontrasepsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wuspusList as $index => $wuspus)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $wuspus->nama }}</td>
                <td>{{ $wuspus->umur }}</td>
                <td>{{ $wuspus->nama_suami }}</td>
                <td>{{ $wuspus->tahapan_ks }}</td>
                <td>{{ $wuspus->dasawisma->nama_dasawisma ?? '-' }}</td>
                <td>{{ $wuspus->jumlah_anak_hidup }}</td>
                <td>{{ $wuspus->anak_meninggal_umur }}</td>
                <td>
                    {{ $wuspus->ukuran_lila_cm }} cm
                    ({{ $wuspus->lebih_23_5_cm == 1 ? '> 23,5 cm' : '<= 23,5 cm' }})
                </td>
                @foreach(['I','II','III','IV','V'] as $tt_ke)
                @php
                $imunisasitt = $wuspus->imunisasitt->firstWhere('tt_ke', $tt_ke);
                @endphp
                <td>{{ $imunisasitt ? \Carbon\Carbon::parse($imunisasitt->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                @endforeach
                <td>{{ $wuspus->jenis_kontrasepsi }}</td>
                <td>{{ $wuspus->tanggal_penggantian ? \Carbon\Carbon::parse($wuspus->tanggal_penggantian)->format('d-m-Y') : '-' }}</td>
                <td>{{ $wuspus->jenis_kontrasepsi_pengganti ?? '-' }}</td>
                <td>
                    <a href="#edit{{$wuspus->wuspus_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#delete{{$wuspus->wuspus_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            @include('sip.edit_delete_format4', ['wuspus' => $wuspus])
            @endforeach
        </tbody>
    </table>
</div>