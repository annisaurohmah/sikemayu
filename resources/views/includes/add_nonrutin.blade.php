<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Kegiatan Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>


            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('nonrutin.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Kegiatan</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama kegiatan" id="name" name="name"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">-- Pilih --</option>
                                @php $categories = ["Seminar", "Literasi", "Bintal", "Lainnya"] @endphp
                                @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Tanggal Kegiatan</label>
                            <input type="date" class="form-control" id="date" name="date"
                                required />
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