@if(!isset($modalType) || $modalType == 'edit')
<!-- Edit -->
<div class="modal fade" id="edit{{$penduduk->nik}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Penduduk</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('penduduk.update', $penduduk->nik) }}">
                    @csrf
                    <input type="hidden" name="nik" value="{{ $penduduk->nik }}" />
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIK" id="nik" name="nik_new" 
                                value="{{ $penduduk->nik ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_kk">No. KK</label>
                                <input type="text" class="form-control" placeholder="Masukkan No. KK" id="no_kk" name="no_kk" 
                                value="{{ $penduduk->no_kk ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap" id="nama" name="nama" 
                        value="{{ $penduduk->nama ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                value="{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ ($penduduk->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ ($penduduk->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shdk">Status Hubungan dalam Keluarga</label>
                                <select class="form-control" id="shdk" name="shdk" required>
                                    <option value="">Pilih SHDK</option>
                                    <option value="Kepala Keluarga" {{ ($penduduk->shdk ?? '') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                    <option value="Istri" {{ ($penduduk->shdk ?? '') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                    <option value="Anak" {{ ($penduduk->shdk ?? '') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                    <option value="Orang Tua" {{ ($penduduk->shdk ?? '') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                    <option value="Lainnya" {{ ($penduduk->shdk ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bpjs">BPJS</label>
                                <input type="text" class="form-control" placeholder="Masukkan No. BPJS" id="bpjs" name="bpjs" 
                                value="{{ $penduduk->bpjs ?? '' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="faskes">Faskes</label>
                                <input type="text" class="form-control" placeholder="Masukkan faskes" id="faskes" name="faskes" 
                                value="{{ $penduduk->faskes ?? '' }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pendidikan">Pendidikan</label>
                                <select class="form-control" id="pendidikan" name="pendidikan">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ ($penduduk->pendidikan ?? '') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="SD" {{ ($penduduk->pendidikan ?? '') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ ($penduduk->pendidikan ?? '') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ ($penduduk->pendidikan ?? '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="D3" {{ ($penduduk->pendidikan ?? '') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ ($penduduk->pendidikan ?? '') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ ($penduduk->pendidikan ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ ($penduduk->pendidikan ?? '') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="Masukkan pekerjaan" id="pekerjaan" name="pekerjaan" 
                        value="{{ $penduduk->pekerjaan ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan alamat" id="alamat" name="alamat" required>{{ $penduduk->alamat ?? '' }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input type="number" class="form-control" placeholder="Masukkan RT" id="rt" name="rt" 
                                value="{{ $penduduk->rt ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <select class="form-control" id="rw" name="rw" required>
                                    <option value="">Pilih RW</option>
                                    @foreach($rw as $rw_item)
                                        <option value="{{ $rw_item->rw_id }}" {{ ($penduduk->rw ?? '') == $rw_item->rw_id ? 'selected' : '' }}>RW {{ $rw_item->no_rw }}</option>
                                    @endforeach
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
@endif

@if(!isset($modalType) || $modalType == 'delete')
<!-- Delete -->
<div class="modal fade" id="delete{{ $penduduk->nik }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Penduduk</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('penduduk.delete', $penduduk->nik) }}">
                    @csrf
                    <input type="hidden" name="nik" value="{{ $penduduk->nik }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $penduduk->nama }}</h2>
                        <p>NIK: {{ $penduduk->nik }}</p>
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
@endif