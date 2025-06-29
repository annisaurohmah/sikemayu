<!-- Tab 6: Format 6 -->
<div class="tab-pane fade table-responsive" id="format6" role="tabpanel">

    <div class="alert alert-info mt-2 mb-2">
        <i class="fa fa-info-circle"></i> Beberapa kolom data Format 6 diisi otomatis berdasarkan perhitungan dari Format 1-5. Tidak dapat ditambah manual.
    </div>

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
                    <a href="#editformat6{{$rekap->id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#deleteformat6{{$rekap->id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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

@foreach($sip6 as $sip6)
<!-- Edit -->
<div class="modal fade" id="editformat6{{$sip6->id}}" tabindex="-1" role="dialog" aria-labelledby="editModal{{$sip6->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{$sip6->id}}"><b>Edit Data Format 6 - SIP (Rekapitulasi Bulanan)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="alert alert-info mb-3">
                    <h6><i class="fa fa-info-circle"></i> Informasi</h6>
                    <p><strong>Data Otomatis:</strong> Bayi 0-12 bulan, Balita 1-5 tahun, Jumlah Lahir, Jumlah Meninggal dihitung otomatis dari Format 1-5.</p>
                    <p><strong>Data Manual:</strong> Kolom lainnya dapat diedit sesuai kondisi di lapangan.</p>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('sip6.update', $sip6->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $sip6->id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $sip6->posyandu_id ?? request()->route('posyandu_id') }}" />

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan_edit_{{ $sip6->id }}">Bulan</label>
                                <select class="form-control" id="bulan_edit_{{ $sip6->id }}" name="bulan" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="1" {{ ($sip6->bulan ?? '') == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ ($sip6->bulan ?? '') == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ ($sip6->bulan ?? '') == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ ($sip6->bulan ?? '') == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ ($sip6->bulan ?? '') == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ ($sip6->bulan ?? '') == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ ($sip6->bulan ?? '') == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ ($sip6->bulan ?? '') == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ ($sip6->bulan ?? '') == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ ($sip6->bulan ?? '') == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ ($sip6->bulan ?? '') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ ($sip6->bulan ?? '') == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun_edit_{{ $sip6->id }}">Tahun</label>
                                <input type="number" class="form-control" placeholder="Masukkan tahun" id="tahun_edit_{{ $sip6->id }}" name="tahun" 
                                value="{{ $sip6->tahun ?? '' }}" min="1900" max="2100" required />
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary mt-3 mb-2">Data Otomatis (Tidak Dapat Diubah)</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bayi_0_12_bulan_edit_{{ $sip6->id }}">Bayi 0-12 bulan</label>
                                <input type="number" class="form-control bg-light" id="bayi_0_12_bulan_edit_{{ $sip6->id }}" name="bayi_0_12_bulan" 
                                value="{{ $sip6->bayi_0_12_bulan ?? '' }}" readonly />
                                <small class="form-text text-muted">Dihitung dari Format 2</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balita_1_5_tahun_edit_{{ $sip6->id }}">Balita 1-5 tahun</label>
                                <input type="number" class="form-control bg-light" id="balita_1_5_tahun_edit_{{ $sip6->id }}" name="balita_1_5_tahun" 
                                value="{{ $sip6->balita_1_5_tahun ?? '' }}" readonly />
                                <small class="form-text text-muted">Dihitung dari Format 3</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bayi_lahir_edit_{{ $sip6->id }}">Jumlah Bayi Lahir</label>
                                <input type="number" class="form-control bg-light" id="bayi_lahir_edit_{{ $sip6->id }}" name="bayi_lahir" 
                                value="{{ $sip6->bayi_lahir ?? '' }}" readonly />
                                <small class="form-text text-muted">Dihitung dari Format 1</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bayi_meninggal_edit_{{ $sip6->id }}">Jumlah Bayi Meninggal</label>
                                <input type="number" class="form-control bg-light" id="bayi_meninggal_edit_{{ $sip6->id }}" name="bayi_meninggal" 
                                value="{{ $sip6->bayi_meninggal ?? '' }}" readonly />
                                <small class="form-text text-muted">Dihitung dari Format 1</small>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4 mb-2">Data Manual (Dapat Diedit)</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_wus_edit_{{ $sip6->id }}">Jumlah WUS</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah WUS" id="jumlah_wus_edit_{{ $sip6->id }}" name="jumlah_wus" 
                                value="{{ $sip6->jumlah_wus ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_pus_edit_{{ $sip6->id }}">Jumlah PUS</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah PUS" id="jumlah_pus_edit_{{ $sip6->id }}" name="jumlah_pus" 
                                value="{{ $sip6->jumlah_pus ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_hamil_edit_{{ $sip6->id }}">Jumlah Ibu Hamil</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah ibu hamil" id="jumlah_hamil_edit_{{ $sip6->id }}" name="jumlah_hamil" 
                                value="{{ $sip6->jumlah_hamil ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_menyusui_edit_{{ $sip6->id }}">Jumlah Ibu Menyusui</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah ibu menyusui" id="jumlah_menyusui_edit_{{ $sip6->id }}" name="jumlah_menyusui" 
                                value="{{ $sip6->jumlah_menyusui ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ibu_hamil_meninggal_edit_{{ $sip6->id }}">Ibu Hamil Meninggal</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah ibu hamil meninggal" id="ibu_hamil_meninggal_edit_{{ $sip6->id }}" name="ibu_hamil_meninggal" 
                                value="{{ $sip6->ibu_hamil_meninggal ?? '' }}" min="0" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ibu_melahirkan_meninggal_edit_{{ $sip6->id }}">Ibu Melahirkan Meninggal</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah ibu melahirkan meninggal" id="ibu_melahirkan_meninggal_edit_{{ $sip6->id }}" name="ibu_melahirkan_meninggal" 
                                value="{{ $sip6->ibu_melahirkan_meninggal ?? '' }}" min="0" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nifas_edit_{{ $sip6->id }}">Jumlah Ibu Nifas</label>
                        <input type="number" class="form-control" placeholder="Masukkan jumlah ibu nifas" id="nifas_edit_{{ $sip6->id }}" name="nifas" 
                        value="{{ $sip6->nifas ?? '' }}" min="0" required />
                    </div>

                    <h6 class="text-info mt-4 mb-2">Data Petugas</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kader_posyandu_edit_{{ $sip6->id }}">Kader Posyandu</label>
                                <input type="number" class="form-control" placeholder="Jumlah kader posyandu" id="kader_posyandu_edit_{{ $sip6->id }}" name="kader_posyandu" 
                                value="{{ $sip6->kader_posyandu ?? '' }}" min="0" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="plkb_edit_{{ $sip6->id }}">PLKB</label>
                                <input type="number" class="form-control" placeholder="Jumlah PLKB" id="plkb_edit_{{ $sip6->id }}" name="plkb" 
                                value="{{ $sip6->plkb ?? '' }}" min="0" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="medis_paramedis_edit_{{ $sip6->id }}">Medis & Paramedis</label>
                                <input type="number" class="form-control" placeholder="Jumlah medis & paramedis" id="medis_paramedis_edit_{{ $sip6->id }}" name="medis_paramedis" 
                                value="{{ $sip6->medis_paramedis ?? '' }}" min="0" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_edit_{{ $sip6->id }}">Keterangan</label>
                        <textarea class="form-control" placeholder="Masukkan keterangan (opsional)" id="keterangan_edit_{{ $sip6->id }}" name="keterangan" rows="3">{{ $sip6->keterangan ?? '' }}</textarea>
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
<div class="modal fade" id="deleteformat6{{ $sip6->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $sip6->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title" id="deleteModal{{ $sip6->id }}"><span class="student_id">Delete Data Format 6 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip6.delete', $sip6->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $sip6->id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">Data Format 6</h2>
                        <p>Bulan: {{ \Carbon\Carbon::create()->month($sip6->bulan)->translatedFormat('F') }} {{ $sip6->tahun }}</p>
                        <p>WUS: {{ $sip6->jumlah_wus }}, PUS: {{ $sip6->jumlah_pus }}</p>
                        <p>Ibu Hamil: {{ $sip6->jumlah_hamil }}, Ibu Menyusui: {{ $sip6->jumlah_menyusui }}</p>
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
@endforeach
