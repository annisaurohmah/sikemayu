<!-- Edit -->
<div class="modal fade" id="edit{{$ibuHamil->ibu_hamil_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 5 - SIP (Ibu Hamil)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip5.update', $ibuHamil->ibu_hamil_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ibu_hamil_id" value="{{ $ibuHamil->ibu_hamil_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $ibuHamil->posyandu_id }}" />
                    
                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu hamil" id="nama_ibu" name="nama_ibu" 
                        value="{{ $ibuHamil->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur" id="umur" name="umur" 
                                value="{{ $ibuHamil->umur ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat_kelompok">Alamat/Kelompok</label>
                                <input type="text" class="form-control" placeholder="Masukkan alamat/kelompok" id="alamat_kelompok" name="alamat_kelompok" 
                                value="{{ $ibuHamil->alamat_kelompok ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                                @foreach($dasawismaList as $dasawisma)
                                    <option value="{{ $dasawisma->dasawisma_id }}" {{ ($ibuHamil->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                        {{ $dasawisma->nama_dasawisma }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
                        <input type="date" class="form-control" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
                        value="{{ $ibuHamil->tanggal_pendaftaran ? $ibuHamil->tanggal_pendaftaran->format('Y-m-d') : '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur_kehamilan">Umur Kehamilan (minggu)</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur kehamilan" id="umur_kehamilan" name="umur_kehamilan" 
                                value="{{ $ibuHamil->umur_kehamilan ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hamil_ke">Hamil Ke-</label>
                                <input type="number" class="form-control" placeholder="Masukkan urutan kehamilan" id="hamil_ke" name="hamil_ke" 
                                value="{{ $ibuHamil->hamil_ke ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ukuran_lila">Ukuran LILA (cm)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila" name="ukuran_lila" 
                                value="{{ $ibuHamil->ukuran_lila ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pmt_pemulihan">PMT Pemulihan</label>
                                <select class="form-control" id="pmt_pemulihan" name="pmt_pemulihan" required>
                                    <option value="">Pilih</option>
                                    <option value="1" {{ ($ibuHamil->pmt_pemulihan ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ ($ibuHamil->pmt_pemulihan ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" placeholder="Masukkan catatan (opsional)" id="catatan" name="catatan" rows="3">{{ $ibuHamil->catatan ?? '' }}</textarea>
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
<div class="modal fade" id="delete{{ $ibuHamil->ibu_hamil_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 5 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip5.delete', $ibuHamil->ibu_hamil_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ibu_hamil_id" value="{{ $ibuHamil->ibu_hamil_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $ibuHamil->nama_ibu }}</h2>
                        <p>Umur: {{ $ibuHamil->umur }} tahun</p>
                        <p>Alamat/Kelompok: {{ $ibuHamil->alamat_kelompok }}</p>
                        <p>Hamil Ke-{{ $ibuHamil->hamil_ke }}</p>
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
    const tanggalPendaftaranInputs = document.querySelectorAll('[name="tanggal_pendaftaran"]');
    
    tanggalPendaftaranInputs.forEach(function(input) {
        input.setAttribute('max', today);
    });
});
</script>