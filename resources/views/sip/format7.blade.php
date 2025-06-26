<!-- Tab 6: Format 6 -->
<div class="tab-pane fade table-responsive" id="format7" role="tabpanel">

    <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format7" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Bulan</th>
                <th colspan="3" class="text-center">Ibu Hamil</th>
                <th rowspan="2">Jumlah Ibu yang Menyusui</th>
                <th rowspan="2">Jumlah Ibu Nifas yang Mendapat Vitamin A</th>
                <th colspan="3" class="text-center">Jumlah Peserta KB yang Mendapat Pelayanan </th>
                <th colspan="5" class="text-center">Penimbangan Balita</th>
                <th colspan="2" class="text-center">Jumlah Bayi dan Balita</th>
                <th colspan="10" class="text-center">Jumlah Bayi yang Diimunisasi</th>
                <th colspan="5" class="text-center">Jumlah WUS dan Bumil yang Mendapat TT</th>
                <th colspan="2" class="text-center">Balita yang Diare</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Jumlah</th>
                <th>Jumlah yang Memeriksakan Diri</th>
                <th>Jumlah yang Mendapat FE</th>

                <th>Kondom</th>
                <th>Pil</th>
                <th>Suntik</th>

                <th>Jumlah Balita Sasaran Posyandu (S)</th>
                <th>Yang Memiliki Buku KMS/Buku KIA (K)</th>
                <th>Yang Ditimbang (D)</th>
                <th>Yang Naik (N)</th>
                <th>Yang BGM</th>

                <th>Yang Mendapat Kapsul Vitamin A</th>
                <th>Yang Mendapat PMT Penyuluhan</th>

                <th>HB 0</th>
                <th>BCG</th>
                <th>Polio I</th>
                <th>Polio II</th>
                <th>Polio III</th>
                <th>Polio IV</th>
                <th>DPT/HB I</th>
                <th>DPT/HB II</th>
                <th>DPT/HB III</th>
                <th>Campak</th>

                <th>I</th>
                <th>II</th>
                <th>III</th>
                <th>IV</th>
                <th>V</th>

                <th>Jumlah Balita</th>
                <th>Jumlah yang Mendapat Oralit</th>
            </tr>
        </thead>
        <tbody>
            @if($sip7 && $sip7->count() > 0)
            @foreach($sip7 as $rekap)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ strtoupper(\Carbon\Carbon::create()->month($rekap->bulan)->translatedFormat('F')) }}</td>
                <td>{{ $rekap->jml_ibu_hamil }}</td>
                <td>{{ $rekap->ibu_periksa }}</td>
                <td>{{ $rekap->ibu_mendapat_fe}}</td>
                <td>{{ $rekap->ibu_menyusui }}</td>
                <td>{{ $rekap->ibu_nifas_dapat_vit_a }}</td>
                <td>{{ $rekap->kb_kondom }}</td>
                <td>{{ $rekap->kb_pil }}</td>
                <td>{{ $rekap->kb_suntik }}</td>
                <td>{{ $rekap->balita_sasaran}}</td>
                <td>{{ $rekap->balita_punya_buku }}</td>
                <td>{{ $rekap->balita_ditimbang }}</td>
                <td>{{ $rekap->balita_naik }}</td>
                <td>{{ $rekap->balita_bgm }}</td>
                <td>{{ $rekap->bayi_balita_vit_a }}</td>
                <td>{{ $rekap->bayi_balita_pmt_penyuluhan }}</td>
                <td>{{ $rekap->imunisasi_hb0 }}</td>
                <td>{{ $rekap->imunisasi_bcg }}</td>
                <td>{{ $rekap->imunisasi_polio_i }}</td>
                <td>{{ $rekap->imunisasi_polio_ii }}</td>
                <td>{{ $rekap->imunisasi_polio_iii }}</td>
                <td>{{ $rekap->imunisasi_polio_iv }}</td>
                <td>{{ $rekap->imunisasi_dpt_hb_i }}</td>
                <td>{{ $rekap->imunisasi_dpt_hb_ii }}</td>
                <td>{{ $rekap->imunisasi_dpt_hb_iii }}</td>
                <td>{{ $rekap->tt_i }}</td>
                <td>{{ $rekap->tt_ii }}</td>
                <td>{{ $rekap->tt_iii }}</td>
                <td>{{ $rekap->tt_iv }}</td>
                <td>{{ $rekap->tt_v }}</td>
                <td>{{ $rekap->imunisasi_campak }}</td>
                <td>{{ $rekap->balita_diare}}</td>
                <td>{{ $rekap->balita_diare_dapat_oralit }}</td>
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