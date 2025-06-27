<!-- Add -->
<div class="modal fade" id="addnewformat6">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 6 - SIP (Rekapitulasi Bulanan)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <h6><i class="fa fa-info-circle"></i> Informasi</h6>
                    <p><strong>Data Otomatis:</strong> Bayi 0-12 bulan, Balita 1-5 tahun, Jumlah Lahir, Jumlah Meninggal dihitung otomatis dari Format 1-5.</p>
                    <p><strong>Data Manual:</strong> Kolom lainnya perlu diisi manual sesuai kondisi di lapangan.</p>
                </div>

                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip6.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select class="form-control" id="bulan" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" placeholder="Masukkan tahun" id="tahun" name="tahun" min="1900" max="2100" required />
                                </div>
                            </div>
                        </div>

                        <h6 class="text-primary mt-3 mb-2">Data Otomatis (Tidak Dapat Diubah)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bayi_0_12_bulan">Bayi 0-12 bulan</label>
                                    <input type="number" class="form-control bg-light" id="bayi_0_12_bulan" name="bayi_0_12_bulan" readonly placeholder="Dihitung otomatis" />
                                    <small class="form-text text-muted">Dihitung dari Format 2</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balita_1_5_tahun">Balita 1-5 tahun</label>
                                    <input type="number" class="form-control bg-light" id="balita_1_5_tahun" name="balita_1_5_tahun" readonly placeholder="Dihitung otomatis" />
                                    <small class="form-text text-muted">Dihitung dari Format 3</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_lahir">Jumlah Bayi Lahir</label>
                                    <input type="number" class="form-control bg-light" id="jumlah_lahir" name="jumlah_lahir" readonly placeholder="Dihitung otomatis" />
                                    <small class="form-text text-muted">Dihitung dari Format 1</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_meninggal">Jumlah Bayi Meninggal</label>
                                    <input type="number" class="form-control bg-light" id="jumlah_meninggal" name="jumlah_meninggal" readonly placeholder="Dihitung otomatis" />
                                    <small class="form-text text-muted">Dihitung dari Format 1</small>
                                </div>
                            </div>
                        </div>

                        <h6 class="text-success mt-4 mb-2">Data Manual (Wajib Diisi)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_wus">Jumlah WUS</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah WUS" id="jumlah_wus" name="jumlah_wus" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_pus">Jumlah PUS</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah PUS" id="jumlah_pus" name="jumlah_pus" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_hamil">Jumlah Ibu Hamil</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah ibu hamil" id="jumlah_hamil" name="jumlah_hamil" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_menyusui">Jumlah Ibu Menyusui</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah ibu menyusui" id="jumlah_menyusui" name="jumlah_menyusui" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ibu_hamil_meninggal">Ibu Hamil Meninggal</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah ibu hamil meninggal" id="ibu_hamil_meninggal" name="ibu_hamil_meninggal" min="0" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ibu_melahirkan_meninggal">Ibu Melahirkan Meninggal</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah ibu melahirkan meninggal" id="ibu_melahirkan_meninggal" name="ibu_melahirkan_meninggal" min="0" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nifas">Jumlah Ibu Nifas</label>
                            <input type="number" class="form-control" placeholder="Masukkan jumlah ibu nifas" id="nifas" name="nifas" min="0" required />
                        </div>

                        <h6 class="text-info mt-4 mb-2">Data Petugas</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kader_posyandu">Kader Posyandu</label>
                                    <input type="number" class="form-control" placeholder="Jumlah kader posyandu" id="kader_posyandu" name="kader_posyandu" min="0" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="plkb">PLKB</label>
                                    <input type="number" class="form-control" placeholder="Jumlah PLKB" id="plkb" name="plkb" min="0" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="medis_paramedis">Medis & Paramedis</label>
                                    <input type="number" class="form-control" placeholder="Jumlah medis & paramedis" id="medis_paramedis" name="medis_paramedis" min="0" required />
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
        </div>
    </div>
</div>

<script>
// Set tahun default ke tahun sekarang
document.addEventListener('DOMContentLoaded', function() {
    const tahunInput = document.getElementById('tahun');
    if (tahunInput) {
        tahunInput.value = new Date().getFullYear();
    }
});
</script>