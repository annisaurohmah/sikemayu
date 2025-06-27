<!-- Edit -->
<div class="modal fade" id="edit{{$wuspus->wuspus_id}}">
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
<div class="modal fade" id="delete{{ $wuspus->wuspus_id }}">
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