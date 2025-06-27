<!-- Add -->
<div class="modal fade" id="addnewformat1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 1 - SIP</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>


            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('sip1.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" placeholder="Masukkan tahun" id="tahun" name="tahun" min="1900" max="2100" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select class="form-control" id="bulan" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </div>
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_meninggal_ibu">Tanggal Meninggal Ibu (Opsional)</label>
                                    <input type="date" class="form-control" id="tgl_meninggal_ibu" name="tgl_meninggal_ibu" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_meninggal_bayi">Tanggal Meninggal Bayi (Opsional)</label>
                                    <input type="date" class="form-control" id="tgl_meninggal_bayi" name="tgl_meninggal_bayi" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" placeholder="Masukkan keterangan (opsional)" id="keterangan" name="keterangan" rows="3"></textarea>
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
            <!-- Log on to codeastro.com for more projects! -->

        </div>
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
    const tglMeninggalIbuInput = document.getElementById('tgl_meninggal_ibu');
    const tglMeninggalBayiInput = document.getElementById('tgl_meninggal_bayi');
    
    if (tglLahirInput) {
        tglLahirInput.setAttribute('max', today);
    }
    if (tglMeninggalIbuInput) {
        tglMeninggalIbuInput.setAttribute('max', today);
    }
    if (tglMeninggalBayiInput) {
        tglMeninggalBayiInput.setAttribute('max', today);
    }
    
    // Set tahun default ke tahun sekarang
    const tahunInput = document.getElementById('tahun');
    if (tahunInput) {
        tahunInput.value = new Date().getFullYear();
    }
});
</script>