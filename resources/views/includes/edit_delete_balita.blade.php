<!-- Edit -->
<div class="modal fade" id="edit{{$balita->nik}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Balita</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('anak.update', $balita->nik) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nik" value="{{ $balita->nik }}" />
                    
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" placeholder="Masukkan NIK" id="nik" name="nik_new" 
                        value="{{ $balita->nik ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap" id="nama_lengkap" name="nama_lengkap" 
                        value="{{ $balita->nama_lengkap ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ ($balita->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ ($balita->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir_balita_edit" name="tanggal_lahir" 
                                value="{{ $balita->tanggal_lahir ? $balita->tanggal_lahir->format('Y-m-d') : '' }}" required onchange="calculateAgeBalitaEdit('{{$balita->nik}}')" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="text" class="form-control" id="umur_balita_edit_{{$balita->nik}}" name="umur" placeholder="Akan dihitung otomatis" readonly style="background-color: #f8f9fa;" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap_ortu">Nama Lengkap Orang Tua</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap orang tua" id="nama_lengkap_ortu" name="nama_lengkap_ortu" 
                        value="{{ $balita->nama_lengkap_ortu ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin_ortu">Jenis Kelamin Orang Tua</label>
                        <select class="form-control" id="jenis_kelamin_ortu" name="jenis_kelamin_ortu" required>
                            <option value="">Pilih Jenis Kelamin Orang Tua</option>
                            <option value="L" {{ ($balita->jenis_kelamin_ortu ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ ($balita->jenis_kelamin_ortu ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete{{ $balita->nik }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Balita</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('anak.delete', $balita->nik) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="nik" value="{{ $balita->nik }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $balita->nama_lengkap }}</h2>
                        <p>NIK: {{ $balita->nik }}</p>
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
function calculateAgeBalitaEdit(nik) {
    const birthDate = document.getElementById('tanggal_lahir_balita_edit').value;
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
        
        document.getElementById('umur_balita_edit_' + nik).value = ageText.trim();
        
        // Cek jika umur < 12 bulan
        if (years === 0 && months < 12) {
            alert('⚠️ PERHATIAN!\n\nAnak dengan umur ' + ageText.trim() + ' sebaiknya disimpan sebagai DATA BAYI, bukan data balita.\n\nData balita diperuntukkan untuk anak berusia 1 tahun atau lebih.');
        }
    } else {
        document.getElementById('umur_balita_edit_' + nik).value = '';
    }
}

// Hitung umur saat modal dibuka
document.addEventListener('DOMContentLoaded', function() {
    // Set tanggal maksimal ke hari ini
    const today = new Date().toISOString().split('T')[0];
    const editDateInput = document.getElementById('tanggal_lahir_balita_edit');
    if (editDateInput) {
        editDateInput.setAttribute('max', today);
        
        // Hitung umur awal jika ada tanggal lahir
        if (editDateInput.value) {
            calculateAgeBalitaEdit('{{$balita->nik ?? ''}}');
        }
    }
});
</script>