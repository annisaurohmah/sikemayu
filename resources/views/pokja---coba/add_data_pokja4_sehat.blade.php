<!-- Add -->
<div class="modal fade" id="addnewdokum" tabindex="-1" role="dialog" aria-labelledby="addModalDokum" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalDokum"><b>Tambah Data Pokja 4 - Bidang Kesehatan</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-add-dokumentasi" method="POST" action="{{ route('dokumentasi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="posyandu_id" value="{{ 'pokja4-c' }}" />
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Catatan:</strong> Unggah foto kegiatan Pokja dalam format JPG, JPEG, PNG dengan ukuran maksimal 5MB.
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                        <small class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan Pokja</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Masukkan nama kegiatan (contoh: Posyandu Bulan Februari, Imunisasi Massal, dll)" 
                               id="nama_kegiatan" name="nama_kegiatan" required maxlength="255" />
                        <small class="form-text text-muted">Berikan nama yang deskriptif untuk kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        <small class="form-text text-muted">Berikan deskripsi yang jelas mengenai kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="file_gambar">File Gambar Dokumentasi <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_gambar" name="file_gambar" 
                                   accept="image/jpeg,image/jpg,image/png" required />
                            <label class="custom-file-label" for="file_gambar">Pilih file gambar...</label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fa fa-exclamation-triangle text-warning"></i>
                            Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran: 5MB
                        </small>
                        
                        <!-- Preview gambar -->
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview Gambar:</label>
                            <div class="border rounded p-2">
                                <img id="preview-img" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                <div class="mt-2">
                                    <small id="file-info" class="text-muted"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <button type="submit" form="form-add-dokumentasi" class="btn btn-success">
                    <i class="fa fa-upload"></i> Simpan Dokumentasi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set tanggal maksimal ke hari ini
    const tanggalInput = document.getElementById('tanggal');
    if (tanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.setAttribute('max', today);
        
        // Set default ke hari ini
        tanggalInput.value = today;
    }
    
    // Handle file input
    const fileInput = document.getElementById('file_gambar');
    const fileLabel = document.querySelector('.custom-file-label');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const fileInfo = document.getElementById('file-info');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Update label
                fileLabel.textContent = file.name;
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    fileInput.value = '';
                    fileLabel.textContent = 'Pilih file gambar...';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Validate file size (5MB max)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    fileInput.value = '';
                    fileLabel.textContent = 'Pilih file gambar...';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                fileLabel.textContent = 'Pilih file gambar...';
                imagePreview.style.display = 'none';
            }
        });
    }
    
    // Form validation
    const form = document.getElementById('form-add-dokumentasi');
    if (form) {
        form.addEventListener('submit', function(e) {
            const tanggal = document.getElementById('tanggal').value;
            const namaKegiatan = document.getElementById('nama_kegiatan').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const fileGambar = document.getElementById('file_gambar').files[0];
            
            if (!tanggal) {
                e.preventDefault();
                alert('Tanggal kegiatan harus diisi!');
                return;
            }
            
            if (!namaKegiatan) {
                e.preventDefault();
                alert('Nama kegiatan harus diisi!');
                return;
            }

            if (!deskripsi) {
                e.preventDefault();
                alert('Deskripsi kegiatan harus diisi!');
                return;
            }
            
            if (!fileGambar) {
                e.preventDefault();
                alert('File gambar dokumentasi harus dipilih!');
                return;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mengupload...';
            }
        });
    }
    
    // Reset form when modal is closed
    $('#addnewdokum').on('hidden.bs.modal', function() {
        const form = document.getElementById('form-add-dokumentasi');
        if (form) {
            form.reset();
            fileLabel.textContent = 'Pilih file gambar...';
            imagePreview.style.display = 'none';
            
            // Reset submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa fa-upload"></i> Simpan Dokumentasi';
            }
        }
    });
});
</script>