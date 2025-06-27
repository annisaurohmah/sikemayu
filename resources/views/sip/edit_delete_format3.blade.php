<!-- Edit Format 3 -->
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
                        <label for="nama_balita_edit">Nama Balita</label>
                        <select class="form-control select2" id="nama_balita_edit_{{$balita->balita_id}}" name="nama_balita" required>
                            <option value="">Pilih Balita</option>
                            @if(isset($balitaList_master))
                                @foreach($balitaList_master as $balita_master)
                                    <option value="{{ $balita_master->nama_lengkap }}" 
                                        data-nik="{{ $balita_master->nik }}" 
                                        data-tgl="{{ $balita_master->tanggal_lahir }}" 
                                        data-orangtua="{{ $balita_master->nama_lengkap_ortu }}"
                                        {{ ($balita->nama_balita ?? '') == $balita_master->nama_lengkap ? 'selected' : '' }}>
                                        {{ $balita_master->nama_lengkap }} - {{ $balita_master->nama_lengkap_ortu }} ({{ $balita_master->tanggal_lahir ? $balita_master->tanggal_lahir->format('d-m-Y') : '' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="form-text text-muted">Pilih dari data balita yang sudah terdaftar atau ketik untuk mencari</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir_edit">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir_edit_{{$balita->balita_id}}" name="tgl_lahir" 
                                value="{{ $balita->tgl_lahir ? $balita->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bb_lahir_edit">Berat Badan Lahir (kg)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" 
                                id="bb_lahir_edit_{{$balita->balita_id}}" name="bb_lahir" value="{{ $balita->bb_lahir ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tb_lahir_edit">Tinggi Badan Lahir (cm)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan tinggi badan lahir" 
                                id="tb_lahir_edit_{{$balita->balita_id}}" name="tb_lahir" value="{{ $balita->tb_lahir ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_orangtua_edit">Nama Orangtua</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama orangtua" 
                                id="nama_orangtua_edit_{{$balita->balita_id}}" name="nama_orangtua" value="{{ $balita->nama_orangtua ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id_edit">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id_edit_{{$balita->balita_id}}" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                                @foreach($dasawismaList as $dasawisma)
                                    <option value="{{ $dasawisma->dasawisma_id }}" {{ ($balita->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                        {{ $dasawisma->nama_dasawisma }}
                                    </option>
                                @endforeach
                            @endif
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

<!-- Delete Format 3 -->
<div class="modal fade" id="delete{{ $balita->balita_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="align-items: center">
                <h4 class="modal-title"><span class="student_id">Delete Data Format 3 - SIP (Balita)</span></h4>
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
                        <p>Nama Orangtua: {{ $balita->nama_orangtua }}</p>
                        <p>Tanggal Lahir: {{ $balita->tgl_lahir ? $balita->tgl_lahir->format('d-m-Y') : '-' }}</p>
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
$(document).ready(function() {
    // Initialize Select2 untuk edit modal ini
    $('#nama_balita_edit_{{$balita->balita_id}}').select2({
        placeholder: "Pilih atau ketik untuk mencari...",
        allowClear: true,
        width: '100%'
    });

    // Auto-fill data ketika balita dipilih di edit modal
    $('#nama_balita_edit_{{$balita->balita_id}}').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const tglLahir = selectedOption.data('tgl');
        const namaOrangtua = selectedOption.data('orangtua');
        
        if (tglLahir) {
            const date = new Date(tglLahir);
            const formattedDate = date.toISOString().split('T')[0];
            $('#tgl_lahir_edit_{{$balita->balita_id}}').val(formattedDate);
        }
        
        if (namaOrangtua) {
            $('#nama_orangtua_edit_{{$balita->balita_id}}').val(namaOrangtua);
        }
    });
});

// Set tanggal maksimal ke hari ini untuk edit modal
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tglLahirEditInput = document.getElementById('tgl_lahir_edit_{{$balita->balita_id}}');
    
    if (tglLahirEditInput) {
        tglLahirEditInput.setAttribute('max', today);
    }
});
</script>