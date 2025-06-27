<!-- Edit -->
<div class="modal fade" id="edit{{$bayi->bayi_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 2 - SIP (Bayi)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip2.update', $bayi->bayi_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bayi_id" value="{{ $bayi->bayi_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $bayi->posyandu_id }}" />
                    
                    <div class="form-group">
                        <label for="nama_bayi">Nama Bayi</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama bayi" id="nama_bayi" name="nama_bayi" 
                        value="{{ $bayi->nama_bayi ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" 
                                value="{{ $bayi->tgl_lahir ? $bayi->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bbl_kg">Berat Badan Lahir (kg)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" id="bbl_kg" name="bbl_kg" 
                                value="{{ $bayi->bbl_kg ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ayah" id="nama_ayah" name="nama_ayah" 
                        value="{{ $bayi->nama_ayah ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" 
                        value="{{ $bayi->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                                @foreach($dasawismaList as $dasawisma)
                                    <option value="{{ $dasawisma->dasawisma_id }}" {{ ($bayi->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>{{ $dasawisma->nama_dasawisma }}</option>
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

<!-- Delete -->
<div class="modal fade" id="delete{{ $bayi->bayi_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 2 - SIP (Bayi)</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip2.delete', $bayi->bayi_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="bayi_id" value="{{ $bayi->bayi_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $bayi->nama_bayi }}</h2>
                        <p>Nama Ayah: {{ $bayi->nama_ayah }}</p>
                        <p>Nama Ibu: {{ $bayi->nama_ibu }}</p>
                        <p>Tanggal Lahir: {{ $bayi->tgl_lahir ? $bayi->tgl_lahir->format('d-m-Y') : '-' }}</p>
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
