<!-- Tab 3: Format 3 -->
<div class="tab-pane fade table-responsive" id="format5" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format5" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Ibu</th>
                <th rowspan="2">Umur</th>
                <th rowspan="2">Alamat Kelompok Dasawisma</th>
                <th colspan="2" class="text-center">Pendaftaran</th>
                <th rowspan="2">Hamil Ke</th>
                <th rowspan="2">LILA</th>
                <th rowspan="2">PMT Pemulihan</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (TB/BB)</th>
                <th colspan="3" class="text-center">Tablet Tambah Darah (BKS)</th>
                <th colspan="5" class="text-center">Imunisasi</th>
                <th rowspan="2">Vitamin A</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Umur Kelahiran (Pekan)</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
                @endforeach

                @foreach(['I','II','III'] as $p)
                <th>{{ $p }}</th>
                @endforeach

                @foreach(['I', 'II', 'III', 'IV', 'V'] as $i)
                <th>{{ $i }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($ibuHamilList as $index => $ibuHamil)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ibuHamil->nama_ibu }}</td>
                <td>{{ $ibuHamil->umur }}</td>
                <td>{{ $ibuHamil->alamat_kelompok }}</td>
                <td>{{ $ibuHamil->tanggal_pendaftaran ? \Carbon\Carbon::parse($ibuHamil->tanggal_pendaftaran)->format('d-m-Y') : '-' }}</td>
                <td>{{ $ibuHamil->umur_kehamilan }}</td>
                <td>{{ $ibuHamil->hamil_ke }}</td>
                <td>{{ $ibuHamil->ukuran_lila ? $ibuHamil->ukuran_lila . ' cm' : '-' }}</td>
                <td>{{ $ibuHamil->pmt_pemulihan ? 'Ya' : 'Tidak' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$ibuHamil->penimbanganIbuHamil->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->tb_hasil_penimbangan }}/{{ $dataTimbang->bb_hasil_penimbangan }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['I','II','III'] as $tablet)
                    @php
                    $tabletTambahDarah = $ibuHamil->tabletTambahDarah->firstWhere('jenis', $tablet);
                    @endphp
                    <td>{{ $tabletTambahDarah ? \Carbon\Carbon::parse($tabletTambahDarah->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['I', 'II', 'III', 'IV', 'V'] as $imun)
                    @php
                    $imunisasittIbuHamil = $ibuHamil->imunisasittIbuHamil->firstWhere('jenis', $imun);
                    @endphp
                    <td>{{ $imunisasittIbuHamil ? \Carbon\Carbon::parse($imunisasittIbuHamil->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach

                    @php
                    $vitaminData = $ibuHamil->vitaminIbuHamil->first();
                    @endphp
                    <td>{{ $vitaminData ? \Carbon\Carbon::parse($vitaminData->tanggal_pemberian)->format('d-m-Y') : '' }}</td>
                    <td>{{ $ibuHamil->catatan ?? '' }}</td>
                    <td>
                        <a href="#edit{{$ibuHamil->ibu_hamil_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                        <a href="#delete{{$ibuHamil->ibu_hamil_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>