<!-- Tab 7: Format 7 -->
<div class="tab-pane fade table-responsive" id="format7" role="tabpanel">

    <div class="alert alert-info mt-2 mb-2">
        <i class="fa fa-info-circle"></i> Data Format 7 diisi otomatis berdasarkan perhitungan dari seluruh format lainnya. Tidak dapat ditambah manual.
    </div>

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
                    <a href="#editformat7{{ $rekap->id }}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#deleteformat7{{ $rekap->id }}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="33" class="text-center">Tidak ada data untuk ditampilkan</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@foreach($sip7 as $rekap)
<!-- Edit -->
<div class="modal fade" id="editformat7{{ $rekap->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 7 - SIP</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip7.update', $rekap->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="rekap_id" value="{{ $rekap->id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $rekap->posyandu_id }}" />
                    <input type="hidden" name="bulan" value="{{ $rekap->bulan }}" />
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Hanya beberapa field yang dapat diedit untuk Format 7
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ibu_menyusui">Jumlah Ibu yang Menyusui</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah ibu menyusui" 
                                id="ibu_menyusui" name="ibu_menyusui" 
                                value="{{ $rekap->ibu_menyusui ?? 0 }}" min="0" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balita_bgm">Balita BGM (Bawah Garis Merah)</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah balita BGM" 
                                id="balita_bgm" name="balita_bgm" 
                                value="{{ $rekap->balita_bgm ?? 0 }}" min="0" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bayi_balita_pmt_penyuluhan">Bayi/Balita yang Mendapat PMT Penyuluhan</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah yang mendapat PMT" 
                                id="bayi_balita_pmt_penyuluhan" name="bayi_balita_pmt_penyuluhan" 
                                value="{{ $rekap->bayi_balita_pmt_penyuluhan ?? 0 }}" min="0" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balita_diare">Jumlah Balita Diare</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah balita diare" 
                                id="balita_diare" name="balita_diare" 
                                value="{{ $rekap->balita_diare ?? 0 }}" min="0" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" placeholder="Masukkan keterangan (opsional)" 
                        id="keterangan" name="keterangan" rows="3">{{ $rekap->keterangan ?? '' }}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                            Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="deleteformat7{{ $rekap->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 7 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip7.delete', $rekap->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="rekap_id" value="{{ $rekap->id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete this Format 7 data?</h6>
                        <h3 class="bold">{{ strtoupper(\Carbon\Carbon::create()->month($rekap->bulan)->translatedFormat('F')) }}</h3>
                        <p>Ibu Menyusui: {{ $rekap->ibu_menyusui }}</p>
                        <p>Balita BGM: {{ $rekap->balita_bgm }}</p>
                        <p>PMT Penyuluhan: {{ $rekap->bayi_balita_pmt_penyuluhan }}</p>
                        <p>Balita Diare: {{ $rekap->balita_diare }}</p>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Format 7 tidak memerlukan validasi tanggal karena hanya berisi data numerik
</script>
@endforeach