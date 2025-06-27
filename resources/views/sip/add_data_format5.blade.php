<!-- Add -->
<div class="modal fade" id="addnewformat5">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 5 - SIP (Ibu Hamil)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip5.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />
                        
                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ibu hamil" id="nama_ibu" name="nama_ibu" required />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="number" class="form-control" placeholder="Masukkan umur" id="umur" name="umur" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_kelompok">Alamat/Kelompok</label>
                                    <input type="text" class="form-control" placeholder="Masukkan alamat/kelompok" id="alamat_kelompok" name="alamat_kelompok" required />
                                </div>
                            </div>
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

                        <div class="form-group">
                            <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
                            <input type="date" class="form-control" id="tanggal_pendaftaran" name="tanggal_pendaftaran" required />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur_kehamilan">Umur Kehamilan (minggu)</label>
                                    <input type="number" class="form-control" placeholder="Masukkan umur kehamilan" id="umur_kehamilan" name="umur_kehamilan" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hamil_ke">Hamil Ke-</label>
                                    <input type="number" class="form-control" placeholder="Masukkan urutan kehamilan" id="hamil_ke" name="hamil_ke" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ukuran_lila">Ukuran LILA (cm)</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila" name="ukuran_lila" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pmt_pemulihan">PMT Pemulihan</label>
                                    <select class="form-control" id="pmt_pemulihan" name="pmt_pemulihan" required>
                                        <option value="">Pilih</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" placeholder="Masukkan catatan (opsional)" id="catatan" name="catatan" rows="3"></textarea>
                        </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_bapak">Nama Bapak</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama bapak" id="nama_bapak" name="nama_bapak" required />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_bayi">Nama Bayi</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama bayi" id="nama_bayi" name="nama_bayi" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required />
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
    const tanggalPendaftaranInput = document.getElementById('tanggal_pendaftaran');
    
    if (tanggalPendaftaranInput) {
        tanggalPendaftaranInput.setAttribute('max', today);
    }
    
    // Set tahun default ke tahun sekarang
    const tahunInput = document.getElementById('tahun');
    if (tahunInput) {
        tahunInput.value = new Date().getFullYear();
    }
});
</script>