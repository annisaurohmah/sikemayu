<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Bayi</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('anak.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" placeholder="Masukkan NIK" id="nik" name="nik" required />
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama lengkap" id="nama_lengkap" name="nama_lengkap" required />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required onchange="calculateAge()" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="text" class="form-control" id="umur" name="umur" placeholder="Akan dihitung otomatis" readonly style="background-color: #f8f9fa;" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap_ortu">Nama Lengkap Orang Tua</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama lengkap orang tua" id="nama_lengkap_ortu" name="nama_lengkap_ortu" required />
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin_ortu">Jenis Kelamin Orang Tua</label>
                            <select class="form-control" id="jenis_kelamin_ortu" name="jenis_kelamin_ortu" required>
                                <option value="">Pilih Jenis Kelamin Orang Tua</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
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
function calculateAge() {
    const birthDate = document.getElementById('tanggal_lahir').value;
    if (birthDate) {
        const today = new Date();
        const birth = new Date(birthDate);
        
        // Hitung selisih dalam milidetik
        const diffTime = today - birth;
        
        // Konversi ke hari
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        
        // Hitung tahun, bulan, dan hari
        const years = Math.floor(diffDays / 365);
        const months = Math.floor((diffDays % 365) / 30);
        const days = Math.floor((diffDays % 365) % 30);
        
        let ageText = '';
        if (years > 0) {
            ageText += years + ' tahun ';
        }
        if (months > 0) {
            ageText += months + ' bulan ';
        }
        if (days > 0 && years === 0) {
            ageText += days + ' hari';
        }
        
        if (ageText === '') {
            ageText = '0 hari';
        }
        
        document.getElementById('umur').value = ageText.trim();
        
        // Cek jika umur >= 12 bulan (1 tahun)
        if (years >= 1 || months >= 12) {
            alert('⚠️ PERHATIAN!\n\nAnak dengan umur ' + ageText.trim() + ' sebaiknya disimpan sebagai DATA BALITA, bukan data bayi.\n\nSilakan gunakan form "Tambah Data Balita" untuk anak berusia 1 tahun atau lebih.');
        }
    } else {
        document.getElementById('umur').value = '';
    }
}

// Set tanggal maksimal ke hari ini
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_lahir').setAttribute('max', today);
});
</script>

