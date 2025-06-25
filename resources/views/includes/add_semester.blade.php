<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Semester Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>


            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('semester.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="semester_name">Nama Semester</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama semester" id="semester_name" name="semester_name"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</i></label>
                            <input type="date" class="form-control" placeholder="Masukkan tanggal mulai" id="start_date" name="start_date"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</i></label>
                            <input type="date" class="form-control" placeholder="Masukkan tanggal selesai" id="end_date" name="end_date"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="is_active">Is Active</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                                <option value="" selected>- Pilih -</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
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
            <!-- Log on to codeastro.com for more projects! -->

        </div>

    </div>
</div>
</div>