<!-- Edit -->

<div class="modal fade" id="edit{{$data->dw_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Dasawisma</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('dasawisma.rekap.update', $data->dw_id) }}">
                    @csrf

                    <input type="hidden" name="dw_id" value="{{ $data->dw_id }}" />

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
                                <input type="text" class="form-control" placeholder="Contoh: 01" id="no_rw" name="no_rw" 
                                       value="{{ $data->no_rw ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_RT">Jumlah RT</label>
                                <input type="number" class="form-control" placeholder="0" id="jumlah_RT" name="jumlah_RT" 
                                       value="{{ $data->jumlah_RT ?? 0 }}" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_DW">Jumlah Dasawisma</label>
                                <input type="number" class="form-control" placeholder="0" id="jumlah_DW" name="jumlah_DW" 
                                       value="{{ $data->jumlah_DW ?? 0 }}" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_KRT">Jumlah KRT</label>
                                <input type="number" class="form-control" placeholder="0" id="jumlah_KRT" name="jumlah_KRT" 
                                       value="{{ $data->jumlah_KRT ?? 0 }}" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_KK">Jumlah KK</label>
                                <input type="number" class="form-control" placeholder="0" id="jumlah_KK" name="jumlah_KK" 
                                       value="{{ $data->jumlah_KK ?? 0 }}" required />
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
                                <input type="number" class="form-control" placeholder="0" id="total_L" name="total_L" 
                                       value="{{ $data->total_L ?? 0 }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_P">Total Perempuan</label>
                                <input type="number" class="form-control" placeholder="0" id="total_P" name="total_P" 
                                       value="{{ $data->total_P ?? 0 }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balita_L">Balita Laki-laki</label>
                                <input type="number" class="form-control" placeholder="0" id="balita_L" name="balita_L" 
                                       value="{{ $data->balita_L ?? 0 }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balita_P">Balita Perempuan</label>
                                <input type="number" class="form-control" placeholder="0" id="balita_P" name="balita_P" 
                                       value="{{ $data->balita_P ?? 0 }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="PUS">PUS</label>
                                <input type="number" class="form-control" placeholder="0" id="PUS" name="PUS" 
                                       value="{{ $data->PUS ?? 0 }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="WUS">WUS</label>
                                <input type="number" class="form-control" placeholder="0" id="WUS" name="WUS" 
                                       value="{{ $data->WUS ?? 0 }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ibu_hamil">Ibu Hamil</label>
                                <input type="number" class="form-control" placeholder="0" id="ibu_hamil" name="ibu_hamil" 
                                       value="{{ $data->ibu_hamil ?? 0 }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ibu_menyusui">Ibu Menyusui</label>
                                <input type="number" class="form-control" placeholder="0" id="ibu_menyusui" name="ibu_menyusui" 
                                       value="{{ $data->ibu_menyusui ?? 0 }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lansia">Lansia</label>
                                <input type="number" class="form-control" placeholder="0" id="lansia" name="lansia" 
                                       value="{{ $data->lansia }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tiga_buta_L">3 Buta Laki-laki</label>
                                <input type="number" class="form-control" placeholder="0" id="tiga_buta_L" name="tiga_buta_L" 
                                       value="{{ $data->tiga_buta_L }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tiga_buta_P">3 Buta Perempuan</label>
                                <input type="number" class="form-control" placeholder="0" id="tiga_buta_P" name="tiga_buta_P" 
                                       value="{{ $data->tiga_buta_P }}" />
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
                                <input type="number" class="form-control" placeholder="0" id="sehat" name="sehat" 
                                       value="{{ $data->sehat }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="krg_sehat">Kurang Sehat</label>
                                <input type="number" class="form-control" placeholder="0" id="krg_sehat" name="krg_sehat" 
                                       value="{{ $data->krg_sehat }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tempat_sampah">Tempat Sampah</label>
                                <input type="number" class="form-control" placeholder="0" id="tempat_sampah" name="tempat_sampah" 
                                       value="{{ $data->tempat_sampah }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="spal">SPAL</label>
                                <input type="number" class="form-control" placeholder="0" id="spal" name="spal" 
                                       value="{{ $data->spal }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="stiker_pak">Stiker P4K</label>
                                <input type="number" class="form-control" placeholder="0" id="stiker_pak" name="stiker_pak" 
                                       value="{{ $data->stiker_pak }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pdam">PDAM</label>
                                <input type="number" class="form-control" placeholder="0" id="pdam" name="pdam" 
                                       value="{{ $data->pdam }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sumur">Sumur</label>
                                <input type="number" class="form-control" placeholder="0" id="sumur" name="sumur" 
                                       value="{{ $data->sumur }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sungai">Sungai</label>
                                <input type="number" class="form-control" placeholder="0" id="sungai" name="sungai" 
                                       value="{{ $data->sungai }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dll">Dll</label>
                                <input type="number" class="form-control" placeholder="0" id="dll" name="dll" 
                                       value="{{ $data->dll }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_jamban">Jamban Keluarga</label>
                                <input type="number" class="form-control" placeholder="0" id="jumlah_jamban" name="jumlah_jamban" 
                                       value="{{ $data->jumlah_jamban }}" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="beras">Beras</label>
                                <input type="number" class="form-control" placeholder="0" id="beras" name="beras" 
                                       value="{{ $data->beras }}" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="non_beras">Non Beras</label>
                                <input type="number" class="form-control" placeholder="0" id="non_beras" name="non_beras" 
                                       value="{{ $data->non_beras }}" />
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
                                <input type="number" class="form-control" placeholder="0" id="up2k" name="up2k" 
                                       value="{{ $data->up2k }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanah_pkrgn">Pemanfaatan Tanah Pekarangan</label>
                                <input type="number" class="form-control" placeholder="0" id="tanah_pkrgn" name="tanah_pkrgn" 
                                       value="{{ $data->tanah_pkrgn }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industri_rt">Industri Rumah Tangga</label>
                                <input type="number" class="form-control" placeholder="0" id="industri_rt" name="industri_rt" 
                                       value="{{ $data->industri_rt }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kesling">Kesehatan Lingkungan</label>
                                <input type="number" class="form-control" placeholder="0" id="kesling" name="kesling" 
                                       value="{{ $data->kesling }}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan keterangan jika ada" id="keterangan" name="keterangan">{{ $data->keterangan ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-check-square-o"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete{{ $data->dw_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="align-items: center">
                <h4 class="modal-title">
                    <span class="text-danger">
                        <i class="fa fa-trash mr-2"></i>Hapus Data Dasawisma
                    </span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('dasawisma.rekap.delete', $data->dw_id) }}">
                    @csrf
                    
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fa fa-exclamation-triangle text-warning" style="font-size: 48px;"></i>
                        </div>
                        <h5>Apakah Anda yakin ingin menghapus data ini?</h5>
                        <div class="alert alert-info mt-3">
                            <strong>Data yang akan dihapus:</strong><br>
                            RW: <strong>{{ $data->no_rw ?? '-' }}</strong><br>
                            Jumlah RT: <strong>{{ $data->jumlah_RT ?? 0 }}</strong><br>
                            Jumlah Dasawisma: <strong>{{ $data->jumlah_DW ?? 0 }}</strong>
                        </div>
                        <p class="text-muted">
                            <small><em>Aksi ini tidak dapat dibatalkan!</em></small>
                        </p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger btn-flat">
                            <i class="fa fa-trash"></i> Ya, Hapus Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>