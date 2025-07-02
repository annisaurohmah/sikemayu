<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fa fa-trash"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="pokja_id" id="delete_pokja_id">
                    
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    
                    <p class="mb-3">
                        <i class="fa fa-question-circle text-danger"></i>
                        Apakah Anda yakin ingin menghapus data kegiatan berikut?
                    </p>
                    
                    <div class="card border-left-danger">
                        <div class="card-body">
                            <h6 class="card-title text-danger mb-2">
                                <i class="fa fa-file-text"></i> Nama Kegiatan:
                            </h6>
                            <p class="card-text font-weight-bold" id="delete_nama_kegiatan">-</p>
                        </div>
                    </div>
                    
                    <p class="text-muted mt-3 mb-0">
                        <small>
                            <i class="fa fa-info-circle"></i>
                            Data yang dihapus termasuk file gambar dokumentasi yang terkait.
                        </small>
                    </p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Ya, Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
