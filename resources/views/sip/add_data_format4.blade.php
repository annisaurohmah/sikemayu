<!-- Add -->
<div class="modal fade" id="addnewformat4">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 4 - SIP (WUS PUS)</b></h5>
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
                                    <label for="status_perkawinan">Status Perkawinan</label>
                                    <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                                        <option value="">Pilih Status Perkawinan</option>
                                        <option value="belum_menikah">Belum Menikah</option>
                                        <option value="menikah">Menikah</option>
                                        <option value="janda">Janda</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="nama_suami_group" style="display: none;">
                            <label for="nama_suami">Nama Suami</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama suami" id="nama_suami" name="nama_suami" />
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

                        <!-- Pemberian Imunisasi TT -->
                        <div class="form-group">
                            <label><strong>Pemberian Imunisasi TT</strong></label>
                            <div class="row">
                                @foreach(['I', 'II', 'III', 'IV', 'V'] as $tt_ke)
                                <div class="col-md-2">
                                    <label for="tt_{{ $tt_ke }}">TT {{ $tt_ke }}</label>
                                    <input type="date" class="form-control" id="tt_{{ $tt_ke }}" name="tt_{{ $tt_ke }}" />
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Kontrasepsi -->
                        <div class="form-group">
                            <label for="jenis_kontrasepsi">Jenis Kontrasepsi yang Dipakai</label>
                            <select class="form-control" id="jenis_kontrasepsi" name="jenis_kontrasepsi">
                                <option value="">Pilih Jenis Kontrasepsi</option>
                                <option value="IUD">IUD</option>
                                <option value="Suntik">Suntik</option>
                                <option value="Pil">Pil</option>
                                <option value="Kondom">Kondom</option>
                                <option value="Implant">Implant</option>
                                <option value="Sterilisasi">Sterilisasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Penggantian Kontrasepsi -->
                        <div class="form-group">
                            <label><strong>Penggantian Kontrasepsi</strong></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tanggal_penggantian">Tanggal Penggantian</label>
                                    <input type="date" class="form-control" id="tanggal_penggantian" name="tanggal_penggantian" />
                                </div>
                                <div class="col-md-6">
                                    <label for="jenis_kontrasepsi_pengganti">Jenis Kontrasepsi Pengganti</label>
                                    <select class="form-control" id="jenis_kontrasepsi_pengganti" name="jenis_kontrasepsi_pengganti">
                                        <option value="">Pilih Jenis Kontrasepsi Pengganti</option>
                                        <option value="IUD">IUD</option>
                                        <option value="Suntik">Suntik</option>
                                        <option value="Pil">Pil</option>
                                        <option value="Kondom">Kondom</option>
                                        <option value="Implant">Implant</option>
                                        <option value="Sterilisasi">Sterilisasi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Set tahun default ke tahun sekarang dan batasi tanggal maksimal ke hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const tahunInput = document.getElementById('tahun');
            if (tahunInput) {
                tahunInput.value = new Date().getFullYear();
            }
            
            // Set tanggal maksimal ke hari ini untuk semua input tanggal
            const today = new Date().toISOString().split('T')[0];
            const dateInputs = document.querySelectorAll('#addnewformat4 input[type="date"]');
            
            dateInputs.forEach(function(input) {
                input.setAttribute('max', today);
            });

            // Handle status perkawinan change
            const statusPerkawinanSelect = document.getElementById('status_perkawinan');
            const namaSuamiGroup = document.getElementById('nama_suami_group');
            const namaSuamiInput = document.getElementById('nama_suami');

            if (statusPerkawinanSelect && namaSuamiGroup && namaSuamiInput) {
                statusPerkawinanSelect.addEventListener('change', function() {
                    if (this.value === 'menikah') {
                        namaSuamiGroup.style.display = 'block';
                        namaSuamiInput.required = true;
                    } else {
                        namaSuamiGroup.style.display = 'none';
                        namaSuamiInput.required = false;
                        namaSuamiInput.value = '';
                    }
                });
            }
        });
    </script>