<!-- Tab 2: Format 2 -->
<div class="tab-pane fade table-responsive" id="format2" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format2" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Bayi</th>
                <th rowspan="2">Tanggal Lahir</th>
                <th rowspan="2">BBL KG</th>
                <th colspan="2" class="text-center">Nama</th>
                <th rowspan="2">Kelompok Dasawisma</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (TB/BB)</th>
                <th colspan="6" class="text-center">Pemberian ASI</th>
                <th colspan="4" class="text-center">Pelayanan</th>
                <th colspan="8" class="text-center">Imunisasi</th>
                <th rowspan="2">Tanggal Bayi Meninggal</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Ayah</th>
                <th>Ibu</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
                @endforeach
                @foreach(['E1','E2','E3','E4','E5','E6'] as $e)
                <th>{{ $e }}</th>
                @endforeach
                @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $p)
                <th>{{ $p }}</th>
                @endforeach
                @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $i)
                <th>{{ $i }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($bayiList as $index => $bayi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $bayi->nama_bayi }}</td>
                <td>{{ \Carbon\Carbon::parse($bayi->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{ $bayi->bbl_kg }}</td>
                <td>{{ $bayi->nama_ayah }}</td>
                <td>{{ $bayi->nama_ibu }}</td>
                <td>{{ $bayi->dasawisma->nama_dasawisma ?? '-' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$bayi->penimbangan->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->tb_hasil_penimbangan }}/{{ $dataTimbang->bb_hasil_penimbangan }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['E1','E2','E3','E4','E5','E6'] as $jenis)
                    @php
                    $asi = $bayi->asi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $asi ? \Carbon\Carbon::parse($asi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach

                    @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $jenis)
                    @php
                    $pelayanan = $bayi->pelayanan->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $pelayanan ? \Carbon\Carbon::parse($pelayanan->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $jenis)
                    @php
                    $imunisasi = $bayi->imunisasi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $imunisasi ? \Carbon\Carbon::parse($imunisasi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach
                    <td>{{ $bayi->keteranganBalita ? \Carbon\Carbon::parse($bayi->keteranganBalita->tanggal_meninggal)->format('d-m-Y') : '' }}</td>
                    <td>{{ $bayi->keteranganBalita->catatan ?? '' }}</td>
                    <td>
                        <a href="#edit{{$bayi->bayi_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                        <a href="#delete{{$bayi->bayi_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>