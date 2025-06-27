<!-- Add -->
<div class="modal fade" id="addnewformat3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 3 - SIP (Balita)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip3.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />

                        <div class="form-group">
                            <label for="nama_balita">Nama Balita</label>
                            <select class="form-control select2" id="nama_balita" name="nama_balita" required>
                                <option value="">Pilih Balita</option>
                                @if(isset($balitaList_master))
                                    @foreach($balitaList_master as $balita)
                                        <option value="{{ $balita->nama_lengkap }}" data-nik="{{ $balita->nik }}" data-tgl="{{ $balita->tanggal_lahir }}" data-orangtua="{{ $balita->nama_lengkap_ortu }}">
                                            {{ $balita->nama_lengkap }} - {{ $balita->nama_lengkap_ortu }} ({{ $balita->tanggal_lahir ? $balita->tanggal_lahir->format('d-m-Y') : '' }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="form-text text-muted">Pilih dari data balita yang sudah terdaftar atau ketik untuk mencari</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bbl_kg">Berat Badan Lahir (kg)</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" id="bbl_kg" name="bbl_kg" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_ayah">Nama Ayah</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ayah" id="nama_ayah" name="nama_ayah" required />
                        </div>

                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" required />
                        </div>

                        <div class="form-group">
                            <label for="dasawisma_id">Dasawisma</label>
                            <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                                <option value="">Pilih Dasawisma</option>
                                @if(isset($dasawismaList))
                                @foreach($dasawismaList as $dasawisma)
                                <option value="{{ $dasawisma->dasawisma_id }}">{{ $dasawisma->nama_dasawisma }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                </div>

                
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set tanggal maksimal ke hari ini
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tglLahirInput = document.getElementById('tgl_lahir');

    if (tglLahirInput) {
        tglLahirInput.setAttribute('max', today);
    }
    
    // Set tahun default ke tahun sekarang
    const tahunInput = document.getElementById('tahun');
    if (tahunInput) {
        tahunInput.value = new Date().getFullYear();
    }
});

// Auto-fill data ketika balita dipilih
$(document).ready(function() {
    $('#nama_balita').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const tglLahir = selectedOption.data('tgl');
        const namaOrangtua = selectedOption.data('orangtua');
        
        if (tglLahir) {
            // Format tanggal untuk input date (YYYY-MM-DD)
            const date = new Date(tglLahir);
            const formattedDate = date.toISOString().split('T')[0];
            $('#tgl_lahir').val(formattedDate);
        }
        
        if (namaOrangtua) {
            $('#nama_orangtua').val(namaOrangtua);
        }
    });
});
</script>