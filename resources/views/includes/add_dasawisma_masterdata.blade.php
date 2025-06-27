<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Dasawisma Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('dasawisma.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nama_dasawisma">Nama Dasawisma</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama dasawisma" id="nama_dasawisma" name="nama_dasawisma" required />
                        </div>

                        <div class="form-group">
                            <label for="alamat_dasawisma">Alamat Dasawisma</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan alamat dasawisma" id="alamat_dasawisma" name="alamat_dasawisma"></textarea>
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
            <!-- Log on to codeastro.com for more projects! -->

        </div>

    </div>
</div>
