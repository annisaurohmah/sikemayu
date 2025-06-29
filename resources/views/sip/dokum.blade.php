<!-- Tab 8: Dokumentasi -->
<div class="tab-pane fade table-responsive" id="dokum" role="tabpanel">

    <a href="#addnewdokum" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-dokum" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th data-priority="1">No</th>
                <th data-priority="2">Tanggal</th>
                <th data-priority="3">Nama Kegiatan</th>
                <th data-priority="4">Dokumentasi</th>
                <th data-priority="5">Aksi</th>
            </tr>
        </thead>
        <tbody>
                @foreach($dokumentasiList as $index => $dokumentasi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($dokumentasi->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $dokumentasi->nama_kegiatan }}</td>
                    <td>
                        @if($dokumentasi->file_path)
                            @php
                                $filePath = public_path('storage/' . $dokumentasi->file_path);
                                $fileExists = file_exists($filePath);
                            @endphp
                            @if($fileExists)
                                <a href="{{ asset('storage/' . $dokumentasi->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fa fa-image"></i> Lihat Foto
                                </a>
                            @else
                                <span class="text-warning">
                                    <i class="fa fa-exclamation-triangle"></i> File tidak ditemukan
                                </span>
                            @endif
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDokumentasi{{ $dokumentasi->id }}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('dokumentasi.delete', $dokumentasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            
        </tbody>
    </table>
</div>

<!-- Add Modal for Dokumentasi -->
<!-- Add -->
<div class="modal fade" id="addnewdokum" tabindex="-1" role="dialog" aria-labelledby="addModalDokum" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalDokum"><b>Tambah Data Dokumentasi Kegiatan - SIP</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-add-dokumentasi" method="POST" action="{{ route('dokumentasi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Catatan:</strong> Unggah foto kegiatan posyandu dalam format JPG, JPEG, PNG dengan ukuran maksimal 5MB.
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                        <small class="form-text text-muted">Pilih tanggal pelaksanaan kegiatan posyandu</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Masukkan nama kegiatan (contoh: Posyandu Bulan Februari, Imunisasi Massal, dll)" 
                               id="nama_kegiatan" name="nama_kegiatan" required maxlength="255" />
                        <small class="form-text text-muted">Berikan nama yang deskriptif untuk kegiatan ini</small>
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


<!-- Edit Modals for Dokumentasi -->
@if(isset($dokumentasiList))
    @foreach($dokumentasiList as $dokumentasi)
    <div class="modal fade" id="editDokumentasi{{ $dokumentasi->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalDokumentasi{{ $dokumentasi->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalDokumentasi{{ $dokumentasi->id }}"><b>Edit Dokumentasi Kegiatan</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="form-edit-dokumentasi-{{ $dokumentasi->id }}" method="POST" action="{{ route('dokumentasi.update', $dokumentasi->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="tanggal_edit_{{ $dokumentasi->id }}">Tanggal Kegiatan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_edit_{{ $dokumentasi->id }}" name="tanggal" 
                                   value="{{ $dokumentasi->tanggal->format('Y-m-d') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="nama_kegiatan_edit_{{ $dokumentasi->id }}">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Masukkan nama kegiatan" 
                                   id="nama_kegiatan_edit_{{ $dokumentasi->id }}" name="nama_kegiatan" 
                                   value="{{ $dokumentasi->nama_kegiatan }}" required maxlength="255" />
                        </div>

                        <div class="form-group">
                            <label for="file_gambar_edit_{{ $dokumentasi->id }}">File Gambar Dokumentasi</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_gambar_edit_{{ $dokumentasi->id }}" name="file_gambar" 
                                       accept="image/jpeg,image/jpg,image/png" />
                                <label class="custom-file-label" for="file_gambar_edit_{{ $dokumentasi->id }}">Pilih file gambar baru (opsional)...</label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle text-info"></i>
                                Kosongkan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG. Maksimal: 5MB
                            </small>
                            
                            @if($dokumentasi->file_path)
                            <div class="mt-2">
                                <small class="text-muted">File saat ini:</small>
                                <div class="border rounded p-2 mt-1">
                                    <img src="{{ asset('storage/' . $dokumentasi->file_path) }}" alt="Current Image" class="img-fluid" style="max-height: 150px;">
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" form="form-edit-dokumentasi-{{ $dokumentasi->id }}" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif

