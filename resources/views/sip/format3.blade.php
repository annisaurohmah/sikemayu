<!-- Tab 2: Format 2 -->
<div class="tab-pane fade table-responsive" id="format2" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format2" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>                                                      
                <th rowspan="2">Nama Balita</th>
                <th rowspan="2">Tanggal Lahir</th>
                <th rowspan="2">BBL KG</th>
                <th colspan="2" class="text-center" s>Nama</th>
                <th rowspan="2">Kelompok Dasawisma</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (TB/BB)</th>
                <th colspan="4" class="text-center">Pelayanan</th>
                <th colspan="8" class="text-center">Imunisasi</th>
                <th rowspan="2">Tanggal Balita Meninggal</th>
                <th rowspan="2">Catatan</th>
            </tr>
            <tr>
                <th>Ayah</th>
                <th>Ibu</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
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
            @foreach($balitaList as $index => $balita)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $balita->nama_balita }}</td>
                <td>{{ \Carbon\Carbon::parse($balita->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{ $balita->bbl_kg }}</td>
                <td>{{ $balita->nama_ayah }}</td>
                <td>{{ $balita->nama_ibu }}</td>
                <td>{{ $balita->dasawisma->nama_dasawisma ?? '-' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$balita->penimbangan->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->tb_hasil_penimbangan }}/{{ $dataTimbang->bb_hasil_penimbangan }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $jenis)
                    @php
                    $pelayanan = $balita->pelayanan->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $pelayanan ? \Carbon\Carbon::parse($pelayanan->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $jenis)
                    @php
                    $imunisasi = $balita->imunisasi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $imunisasi ? \Carbon\Carbon::parse($imunisasi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach
                        <td>{{ $balita->keteranganBalita ? \Carbon\Carbon::parse($balita->keteranganBalita->tanggal_meninggal)->format('d-m-Y') : '' }}</td>
                    <td>{{ $balita->keteranganBalita->catatan ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>