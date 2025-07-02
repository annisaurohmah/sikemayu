<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fa fa-edit"></i> Edit Data Pokja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="pokja_id" id="edit_pokja_id">
                    
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> 
                        <strong>Catatan:</strong> Biarkan kosong jika tidak ingin mengubah gambar.
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_judul_pokja">Judul Pokja <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_judul_pokja" name="judul_pokja" 
                               readonly style="background-color: #f8f9fa;">
                        <small class="form-text text-muted">Judul pokja tidak dapat diubah</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                        <small class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_kegiatan" name="nama_kegiatan" 
                               placeholder="Masukkan nama kegiatan" required maxlength="255">
                        <small class="form-text text-muted">Berikan nama yang deskriptif untuk kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Jelaskan detail kegiatan yang dilaksanakan" required></textarea>
                        <small class="form-text text-muted">Berikan deskripsi yang jelas mengenai kegiatan ini</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_file_gambar">File Gambar Dokumentasi</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="edit_file_gambar" name="file_gambar" 
                                   accept="image/jpeg,image/jpg,image/png">
                            <label class="custom-file-label" for="edit_file_gambar">Pilih file gambar baru...</label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fa fa-info-circle text-info"></i>
                            Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran: 5MB. Kosongkan jika tidak ingin mengubah.
                        </small>
                        
                        <!-- Preview gambar -->
                        <div id="edit-image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview Gambar Baru:</label>
                            <div class="border rounded p-2">
                                <img id="edit-preview-img" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                <div class="mt-2">
                                    <small id="edit-file-info" class="text-muted"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set tanggal maksimal ke hari ini
    const editTanggalInput = document.getElementById('edit_tanggal');
    if (editTanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        editTanggalInput.setAttribute('max', today);
    }
    
    // Handle file input for edit modal
    const editFileInput = document.getElementById('edit_file_gambar');
    const editFileLabel = editFileInput?.nextElementSibling;
    const editImagePreview = document.getElementById('edit-image-preview');
    const editPreviewImg = document.getElementById('edit-preview-img');
    const editFileInfo = document.getElementById('edit-file-info');
    
    if (editFileInput) {
        editFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Update label
                editFileLabel.textContent = file.name;
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    editFileInput.value = '';
                    editFileLabel.textContent = 'Pilih file gambar baru...';
                    editImagePreview.style.display = 'none';
                    return;
                }
                
                // Validate file size (5MB max)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    editFileInput.value = '';
                    editFileLabel.textContent = 'Pilih file gambar baru...';
                    editImagePreview.style.display = 'none';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    editPreviewImg.src = e.target.result;
                    editFileInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    editImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                editFileLabel.textContent = 'Pilih file gambar baru...';
                editImagePreview.style.display = 'none';
            }
        });
    }
    
    // Reset form when modal is closed
    $('#editModal').on('hidden.bs.modal', function() {
        const form = document.getElementById('editForm');
        if (form) {
            if (editFileLabel) editFileLabel.textContent = 'Pilih file gambar baru...';
            if (editImagePreview) editImagePreview.style.display = 'none';
            if (editFileInput) editFileInput.value = '';
        }
    });
});
</script>
