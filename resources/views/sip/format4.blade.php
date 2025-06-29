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
                <td>{{ $imunisasitt ? \Carbon\Carbon::parse($imunisasitt->tanggal_pemberian)->format('d-m-Y') : '' }}</td>
                @endforeach
                @php
                $kontrasepsi = $wuspus->kontrasepsi->first();
                $penggantian = $wuspus->penggantianKontrasepsi->first();
                @endphp
                <td>{{ $kontrasepsi->jenis_kontrasepsi ?? '-' }}</td>
                <td>{{ $penggantian && $penggantian->tanggal_penggantian ? \Carbon\Carbon::parse($penggantian->tanggal_penggantian)->format('d-m-Y') : '-' }}</td>
                <td>{{ $penggantian->jenis_baru ?? '-' }}</td>
                <td>
                    <a href="#editformat4{{$wuspus->wuspus_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#deleteformat4{{$wuspus->wuspus_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($wuspusList as $wuspus)
<!-- Edit -->
<div class="modal fade" id="editformat4{{$wuspus->wuspus_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 4 - SIP (WUS PUS)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip4.update', $wuspus->wuspus_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="wuspus_id" value="{{ $wuspus->wuspus_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $wuspus->posyandu_id }}" />
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" id="bulan" name="bulan" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="1" {{ ($wuspus->bulan ?? '') == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ ($wuspus->bulan ?? '') == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ ($wuspus->bulan ?? '') == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ ($wuspus->bulan ?? '') == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ ($wuspus->bulan ?? '') == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ ($wuspus->bulan ?? '') == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ ($wuspus->bulan ?? '') == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ ($wuspus->bulan ?? '') == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ ($wuspus->bulan ?? '') == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ ($wuspus->bulan ?? '') == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ ($wuspus->bulan ?? '') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ ($wuspus->bulan ?? '') == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control" placeholder="Masukkan tahun" id="tahun" name="tahun" 
                                value="{{ $wuspus->tahun ?? '' }}" min="1900" max="2100" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama WUS/PUS</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama WUS/PUS" id="nama" name="nama" 
                        value="{{ $wuspus->nama ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur" id="umur" name="umur" 
                                value="{{ $wuspus->umur ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_suami">Nama Suami</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama suami" id="nama_suami" name="nama_suami" 
                                value="{{ $wuspus->nama_suami ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tahapan_ks">Tahapan KS</label>
                        <select class="form-control" id="tahapan_ks" name="tahapan_ks" required>
                            <option value="">Pilih Tahapan KS</option>
                            <option value="KS1" {{ ($wuspus->tahapan_ks ?? '') == 'KS1' ? 'selected' : '' }}>KS1</option>
                            <option value="KS2" {{ ($wuspus->tahapan_ks ?? '') == 'KS2' ? 'selected' : '' }}>KS2</option>
                            <option value="KS3" {{ ($wuspus->tahapan_ks ?? '') == 'KS3' ? 'selected' : '' }}>KS3</option>
                            <option value="KS4" {{ ($wuspus->tahapan_ks ?? '') == 'KS4' ? 'selected' : '' }}>KS4</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                                @foreach($dasawismaList as $dasawisma)
                                    <option value="{{ $dasawisma->dasawisma_id }}" {{ ($wuspus->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                        {{ $dasawisma->nama_dasawisma }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_anak_hidup">Jumlah Anak Hidup</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah anak hidup" id="jumlah_anak_hidup" name="jumlah_anak_hidup" 
                                value="{{ $wuspus->jumlah_anak_hidup ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="anak_meninggal_umur">Anak Meninggal Umur</label>
                                <input type="text" class="form-control" placeholder="Masukkan umur anak meninggal (opsional)" id="anak_meninggal_umur" name="anak_meninggal_umur" 
                                value="{{ $wuspus->anak_meninggal_umur ?? '' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ukuran_lila_cm">Ukuran LILA (cm)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila_cm" name="ukuran_lila_cm" 
                                value="{{ $wuspus->ukuran_lila_cm ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lebih_23_5_cm">Lebih dari 23.5 cm?</label>
                                <select class="form-control" id="lebih_23_5_cm" name="lebih_23_5_cm" required>
                                    <option value="">Pilih</option>
                                    <option value="1" {{ ($wuspus->lebih_23_5_cm ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ ($wuspus->lebih_23_5_cm ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pemberian Imunisasi TT -->
                    <div class="form-group">
                        <label><strong>Pemberian Imunisasi TT</strong></label>
                        <div class="row">
                            @foreach(['I', 'II', 'III', 'IV', 'V'] as $tt_ke)
                            @php
                            $imunisasitt = $wuspus->imunisasitt->firstWhere('tt_ke', $tt_ke);
                            @endphp
                            <div class="col-md-2">
                                <label for="tt_{{ $tt_ke }}">TT {{ $tt_ke }}</label>
                                <input type="date" class="form-control" id="tt_{{ $tt_ke }}" name="tt_{{ $tt_ke }}" 
                                value="{{ $imunisasitt ? $imunisasitt->tanggal_pemberian->format('Y-m-d') : '' }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kontrasepsi -->
                    <div class="form-group">
                        <label for="jenis_kontrasepsi">Jenis Kontrasepsi yang Dipakai</label>
                        @php
                        $kontrasepsi = $wuspus->kontrasepsi->first();
                        @endphp
                        <select class="form-control" id="jenis_kontrasepsi" name="jenis_kontrasepsi">
                            <option value="">Pilih Jenis Kontrasepsi</option>
                            <option value="IUD" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'IUD' ? 'selected' : '' }}>IUD</option>
                            <option value="Suntik" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Suntik' ? 'selected' : '' }}>Suntik</option>
                            <option value="Pil" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Pil' ? 'selected' : '' }}>Pil</option>
                            <option value="Kondom" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Kondom' ? 'selected' : '' }}>Kondom</option>
                            <option value="Implant" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Implant' ? 'selected' : '' }}>Implant</option>
                            <option value="Sterilisasi" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Sterilisasi' ? 'selected' : '' }}>Sterilisasi</option>
                            <option value="Lainnya" {{ ($kontrasepsi->jenis_kontrasepsi ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <!-- Penggantian Kontrasepsi -->
                    <div class="form-group">
                        <label><strong>Penggantian Kontrasepsi</strong></label>
                        @php
                        $penggantian = $wuspus->penggantianKontrasepsi->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tanggal_penggantian">Tanggal Penggantian</label>
                                <input type="date" class="form-control" id="tanggal_penggantian" name="tanggal_penggantian" 
                                value="{{ $penggantian && $penggantian->tanggal_penggantian ? $penggantian->tanggal_penggantian->format('Y-m-d') : '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kontrasepsi_pengganti">Jenis Kontrasepsi Pengganti</label>
                                <select class="form-control" id="jenis_kontrasepsi_pengganti" name="jenis_kontrasepsi_pengganti">
                                    <option value="">Pilih Jenis Kontrasepsi Pengganti</option>
                                    <option value="IUD" {{ ($penggantian->jenis_baru ?? '') == 'IUD' ? 'selected' : '' }}>IUD</option>
                                    <option value="Suntik" {{ ($penggantian->jenis_baru ?? '') == 'Suntik' ? 'selected' : '' }}>Suntik</option>
                                    <option value="Pil" {{ ($penggantian->jenis_baru ?? '') == 'Pil' ? 'selected' : '' }}>Pil</option>
                                    <option value="Kondom" {{ ($penggantian->jenis_baru ?? '') == 'Kondom' ? 'selected' : '' }}>Kondom</option>
                                    <option value="Implant" {{ ($penggantian->jenis_baru ?? '') == 'Implant' ? 'selected' : '' }}>Implant</option>
                                    <option value="Sterilisasi" {{ ($penggantian->jenis_baru ?? '') == 'Sterilisasi' ? 'selected' : '' }}>Sterilisasi</option>
                                    <option value="Lainnya" {{ ($penggantian->jenis_baru ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>
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
<div class="modal fade" id="deleteformat4{{ $wuspus->wuspus_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 4 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip4.delete', $wuspus->wuspus_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="wuspus_id" value="{{ $wuspus->wuspus_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $wuspus->nama }}</h2>
                        <p>Nama Suami: {{ $wuspus->nama_suami }}</p>
                        <p>Umur: {{ $wuspus->umur }} tahun</p>
                        <p>{{ $wuspus->tahun }} - Bulan {{ $wuspus->bulan }}</p>
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
// Set tanggal maksimal ke hari ini untuk semua input tanggal edit di Format 4
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('#editformat4 input[type="date"]');
    
    dateInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
});
</script>
@endforeach