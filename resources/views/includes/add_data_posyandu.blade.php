<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Posyandu Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('posyandu.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama_posyandu">Nama Posyandu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama posyandu" id="nama_posyandu" name="nama_posyandu" required />
                        </div>
                        
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save mr-2"></i>Simpan
                                </button>
                                <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">
                                    <i class="mdi mdi-close mr-2"></i>Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>