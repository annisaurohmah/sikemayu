<!-- Add -->
<div class="modal fade" id="addnewdokum">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Dokumentasi - SIP</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip4.store') }}">
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
                        
                        <div class="form-group">
                            <label for="nama">Nama WUS/PUS</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama WUS/PUS" id="nama" name="nama" required />
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
                                    <label for="nama_suami">Nama Suami</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama suami" id="nama_suami" name="nama_suami" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tahapan_ks">Tahapan KS</label>
                            <select class="form-control" id="tahapan_ks" name="tahapan_ks" required>
                                <option value="">Pilih Tahapan KS</option>
                                <option value="KS1">KS1</option>
                                <option value="KS2">KS2</option>
                                <option value="KS3">KS3</option>
                                <option value="KS4">KS4</option>
                            </select>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah_anak_hidup">Jumlah Anak Hidup</label>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah anak hidup" id="jumlah_anak_hidup" name="jumlah_anak_hidup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="anak_meninggal_umur">Anak Meninggal Umur</label>
                                    <input type="text" class="form-control" placeholder="Masukkan umur anak meninggal (opsional)" id="anak_meninggal_umur" name="anak_meninggal_umur" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ukuran_lila_cm">Ukuran LILA (cm)</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila_cm" name="ukuran_lila_cm" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lebih_23_5_cm">Lebih dari 23.5 cm?</label>
                                    <select class="form-control" id="lebih_23_5_cm" name="lebih_23_5_cm" required>
                                        <option value="">Pilih</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
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