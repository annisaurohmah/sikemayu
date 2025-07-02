<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">
                    <i class="fa fa-plus-circle"></i> Tambah Data Pokja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="{{ route('pokja.store') }}" enctype="multipart/form-data" id="addForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="nama_pokja" id="add_nama_pokja">
                    <input type="hidden" name="judul_pokja" id="add_judul_pokja">
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Catatan:</strong> Unggah foto kegiatan dalam format JPG, JPEG, PNG dengan ukuran maksimal 5MB.
                    </div>
                    
                    <div class="form-group">
                        <label for="add_tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="add_tanggal" name="tanggal" required>
                        <small class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan</small>
                    </div>

                    <div class="form-group">
                        <label for="add_nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_nama_kegiatan" name="nama_kegiatan" 
                               placeholder="Masukkan nama kegiatan" required maxlength="255">
                        <small class="form-text text-muted">Berikan nama yang deskriptif untuk kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="add_deskripsi">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="add_deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Jelaskan detail kegiatan yang dilaksanakan" required></textarea>
                        <small class="form-text text-muted">Berikan deskripsi yang jelas mengenai kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="add_file_gambar">File Gambar Dokumentasi <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="add_file_gambar" name="file_gambar" 
                                   accept="image/jpeg,image/jpg,image/png" required>
                            <label class="custom-file-label" for="add_file_gambar">Pilih file gambar...</label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fa fa-exclamation-triangle text-warning"></i>
                            Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran: 5MB
                        </small>
                        
                        <!-- Preview gambar -->
                        <div id="add-image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview Gambar:</label>
                            <div class="border rounded p-2">
                                <img id="add-preview-img" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                <div class="mt-2">
                                    <small id="add-file-info" class="text-muted"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set tanggal maksimal ke hari ini
    const addTanggalInput = document.getElementById('add_tanggal');
    if (addTanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        addTanggalInput.setAttribute('max', today);
        addTanggalInput.value = today;
    }
    
    // Handle file input for add modal
    const addFileInput = document.getElementById('add_file_gambar');
    const addFileLabel = addFileInput?.nextElementSibling;
    const addImagePreview = document.getElementById('add-image-preview');
    const addPreviewImg = document.getElementById('add-preview-img');
    const addFileInfo = document.getElementById('add-file-info');
    
    if (addFileInput) {
        addFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Update label
                addFileLabel.textContent = file.name;
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    addFileInput.value = '';
                    addFileLabel.textContent = 'Pilih file gambar...';
                    addImagePreview.style.display = 'none';
                    return;
                }
                
                // Validate file size (5MB max)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    addFileInput.value = '';
                    addFileLabel.textContent = 'Pilih file gambar...';
                    addImagePreview.style.display = 'none';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    addPreviewImg.src = e.target.result;
                    addFileInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    addImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                addFileLabel.textContent = 'Pilih file gambar...';
                addImagePreview.style.display = 'none';
            }
        });
    }
    
    // Reset form when modal is closed
    $('#addModal').on('hidden.bs.modal', function() {
        const form = document.getElementById('addForm');
        if (form) {
            form.reset();
            if (addFileLabel) addFileLabel.textContent = 'Pilih file gambar...';
            if (addImagePreview) addImagePreview.style.display = 'none';
            
            // Reset date to today
            if (addTanggalInput) {
                const today = new Date().toISOString().split('T')[0];
                addTanggalInput.value = today;
            }
        }
    });
});
</script>
