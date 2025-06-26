<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Dasawisma Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('dasawisma.rekap.store') }}">
                        @csrf
                        
                        <!-- Data Wilayah -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary font-weight-bold mb-3">Data Wilayah</h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rw">Nomor RW</label>
                                    <input type="text" class="form-control" placeholder="Contoh: 01" id="no_rw" name="no_rw" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_RT">Jumlah RT</label>
                                    <input type="number" class="form-control" placeholder="0" id="jumlah_RT" name="jumlah_RT" required />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_DW">Jumlah Dasawisma</label>
                                    <input type="number" class="form-control" placeholder="0" id="jumlah_DW" name="jumlah_DW" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_KRT">Jumlah KRT</label>
                                    <input type="number" class="form-control" placeholder="0" id="jumlah_KRT" name="jumlah_KRT" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_KK">Jumlah KK</label>
                                    <input type="number" class="form-control" placeholder="0" id="jumlah_KK" name="jumlah_KK" required />
                                </div>
                            </div>
                        </div>

                        <!-- Data Anggota Keluarga -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary font-weight-bold mb-3 mt-4">Data Anggota Keluarga</h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_L">Total Laki-laki</label>
                                    <input type="number" class="form-control" placeholder="0" id="total_L" name="total_L" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_P">Total Perempuan</label>
                                    <input type="number" class="form-control" placeholder="0" id="total_P" name="total_P" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balita_L">Balita Laki-laki</label>
                                    <input type="number" class="form-control" placeholder="0" id="balita_L" name="balita_L" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balita_P">Balita Perempuan</label>
                                    <input type="number" class="form-control" placeholder="0" id="balita_P" name="balita_P" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="PUS">PUS</label>
                                    <input type="number" class="form-control" placeholder="0" id="PUS" name="PUS" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="WUS">WUS</label>
                                    <input type="number" class="form-control" placeholder="0" id="WUS" name="WUS" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ibu_hamil">Ibu Hamil</label>
                                    <input type="number" class="form-control" placeholder="0" id="ibu_hamil" name="ibu_hamil" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ibu_menyusui">Ibu Menyusui</label>
                                    <input type="number" class="form-control" placeholder="0" id="ibu_menyusui" name="ibu_menyusui" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lansia">Lansia</label>
                                    <input type="number" class="form-control" placeholder="0" id="lansia" name="lansia" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tiga_buta_L">3 Buta Laki-laki</label>
                                    <input type="number" class="form-control" placeholder="0" id="tiga_buta_L" name="tiga_buta_L" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tiga_buta_P">3 Buta Perempuan</label>
                                    <input type="number" class="form-control" placeholder="0" id="tiga_buta_P" name="tiga_buta_P" />
                                </div>
                            </div>
                        </div>

                        <!-- Kriteria Rumah, Air & Makanan -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary font-weight-bold mb-3 mt-4">Kriteria Rumah, Air & Makanan</h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sehat">Rumah Sehat</label>
                                    <input type="number" class="form-control" placeholder="0" id="sehat" name="sehat" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="krg_sehat">Kurang Sehat</label>
                                    <input type="number" class="form-control" placeholder="0" id="krg_sehat" name="krg_sehat" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tempat_sampah">Tempat Sampah</label>
                                    <input type="number" class="form-control" placeholder="0" id="tempat_sampah" name="tempat_sampah" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="spal">SPAL</label>
                                    <input type="number" class="form-control" placeholder="0" id="spal" name="spal" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="stiker_pak">Stiker P4K</label>
                                    <input type="number" class="form-control" placeholder="0" id="stiker_pak" name="stiker_pak" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pdam">PDAM</label>
                                    <input type="number" class="form-control" placeholder="0" id="pdam" name="pdam" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sumur">Sumur</label>
                                    <input type="number" class="form-control" placeholder="0" id="sumur" name="sumur" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sungai">Sungai</label>
                                    <input type="number" class="form-control" placeholder="0" id="sungai" name="sungai" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dll">Dll</label>
                                    <input type="number" class="form-control" placeholder="0" id="dll" name="dll" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_jamban">Jamban Keluarga</label>
                                    <input type="number" class="form-control" placeholder="0" id="jumlah_jamban" name="jumlah_jamban" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="beras">Beras</label>
                                    <input type="number" class="form-control" placeholder="0" id="beras" name="beras" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="non_beras">Non Beras</label>
                                    <input type="number" class="form-control" placeholder="0" id="non_beras" name="non_beras" />
                                </div>
                            </div>
                        </div>

                        <!-- Partisipasi Warga -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary font-weight-bold mb-3 mt-4">Partisipasi Warga</h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="up2k">UP2K</label>
                                    <input type="number" class="form-control" placeholder="0" id="up2k" name="up2k" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanah_pkrgn">Pemanfaatan Tanah Pekarangan</label>
                                    <input type="number" class="form-control" placeholder="0" id="tanah_pkrgn" name="tanah_pkrgn" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="industri_rt">Industri Rumah Tangga</label>
                                    <input type="number" class="form-control" placeholder="0" id="industri_rt" name="industri_rt" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kesling">Kesehatan Lingkungan</label>
                                    <input type="number" class="form-control" placeholder="0" id="kesling" name="kesling" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan keterangan jika ada" id="keterangan" name="keterangan"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save mr-2"></i>Simpan Data
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    <i class="mdi mdi-refresh mr-2"></i>Reset
                                </button>
                                <button type="button" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">
                                    <i class="mdi mdi-close mr-2"></i>Batal
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