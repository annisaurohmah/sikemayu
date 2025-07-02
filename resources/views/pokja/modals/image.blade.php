<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fa fa-image"></i> Preview Dokumentasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body text-center p-0">
                <div class="bg-dark p-3">
                    <h6 class="text-white mb-3" id="modalImageTitle">Judul Kegiatan</h6>
                    <img id="modalImage" 
                         src="" 
                         alt="Dokumentasi Kegiatan" 
                         class="img-fluid rounded shadow"
                         style="max-height: 70vh; width: auto;">
                </div>
            </div>
            
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
                <a id="downloadImageBtn" href="#" download class="btn btn-primary">
                    <i class="fa fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Update download link when modal is shown
$('#imageModal').on('show.bs.modal', function() {
    const imageSrc = document.getElementById('modalImage').src;
    const downloadBtn = document.getElementById('downloadImageBtn');
    downloadBtn.href = imageSrc;
});
</script>
