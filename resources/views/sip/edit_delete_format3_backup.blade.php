<!-- Edit -->
<div class="modal fade" id="edit{{$balita->balita_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 3 - SIP (Balita)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip3.update', $balita->balita_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="balita_id" value="{{ $balita->balita_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $balita->posyandu_id }}" />
                    
                    <div class="form-group">
                        <label for="nama_balita">Nama Balita</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama balita" id="nama_balita" name="nama_balita" 
                        value="{{ $balita->nama_balita ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" 
                                value="{{ $balita->tgl_lahir ? $balita->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bbl_kg">Berat Badan Lahir (kg)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" id="bbl_kg" name="bbl_kg" 
                                value="{{ $balita->bbl_kg ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ayah" id="nama_ayah" name="nama_ayah" 
                        value="{{ $balita->nama_ayah ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" 
                        value="{{ $balita->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @foreach($dasawismaList as $dw)
                                <option value="{{ $dw->dasawisma_id }}" {{ ($balita->dasawisma_id ?? '') == $dw->dasawisma_id ? 'selected' : '' }}>
                                    {{ $dw->nama_dasawisma }}
                                </option>
                            @endforeach
                        </select>
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
<div class="modal fade" id="delete{{ $balita->balita_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 3 - SIP (Balita)</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip3.delete', $balita->balita_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="balita_id" value="{{ $balita->balita_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $balita->nama_balita }}</h2>
                        <p>Nama Ayah: {{ $balita->nama_ayah }}</p>
                        <p>Nama Ibu: {{ $balita->nama_ibu }}</p>
                        <p>Tanggal Lahir: {{ $balita->tgl_lahir ? $balita->tgl_lahir->format('d-m-Y') : '' }}</p>
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
// Set tanggal maksimal ke hari ini untuk semua input tanggal edit
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tglLahirInputs = document.querySelectorAll('[name="tgl_lahir"]');
    
    tglLahirInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
});
</script>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_bapak">Nama Bapak</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama bapak" id="nama_bapak" name="nama_bapak" 
                        value="{{ $sip1->nama_bapak ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_bayi">Nama Bayi</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama bayi" id="nama_bayi" name="nama_bayi" 
                                value="{{ $sip1->nama_bayi ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" 
                                value="{{ $sip1->tgl_lahir ? $sip1->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_meninggal_ibu">Tanggal Meninggal Ibu (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_meninggal_ibu" name="tgl_meninggal_ibu" 
                                value="{{ $sip1->tgl_meninggal_ibu ? $sip1->tgl_meninggal_ibu->format('Y-m-d') : '' }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_meninggal_bayi">Tanggal Meninggal Bayi (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_meninggal_bayi" name="tgl_meninggal_bayi" 
                                value="{{ $sip1->tgl_meninggal_bayi ? $sip1->tgl_meninggal_bayi->format('Y-m-d') : '' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" placeholder="Masukkan keterangan (opsional)" id="keterangan" name="keterangan" rows="3">{{ $sip1->keterangan ?? '' }}</textarea>
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
<div class="modal fade" id="delete{{ $sip1->sip1_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 1 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip1.delete', $sip1->sip1_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="sip1_id" value="{{ $sip1->sip1_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $sip1->nama_bayi }}</h2>
                        <p>Nama Ibu: {{ $sip1->nama_ibu }}</p>
                        <p>Nama Bapak: {{ $sip1->nama_bapak }}</p>
                        <p>{{ $sip1->tahun }} - {{ $sip1->bulan }}</p>
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
// Set tanggal maksimal ke hari ini untuk semua input tanggal edit
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tglLahirInputs = document.querySelectorAll('[name="tgl_lahir"]');
    const tglMeninggalIbuInputs = document.querySelectorAll('[name="tgl_meninggal_ibu"]');
    const tglMeninggalBayiInputs = document.querySelectorAll('[name="tgl_meninggal_bayi"]');
    
    tglLahirInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
    
    tglMeninggalIbuInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
    
    tglMeninggalBayiInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
});
</script>