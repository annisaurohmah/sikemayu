<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Mahasiswa Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>


            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('student.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama mahasiswa" id="name" name="name"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM</i></label>
                            <input type="text" class="form-control" placeholder="Masukkan NIM mahasiswa" id="nim" name="nim"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="name">Agama</label>
                            <select class="form-control" id="religion" name="religion" required>
                                <option value="" selected>- Pilih -</option>
                                <option value="Islam">Islam</option>
                                <option value="Protestan">Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Program Studi</i></label>
                            <input type="text" class="form-control" placeholder="Masukkan prodi mahasiswa" id="prodi" name="prodi"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="province">Provinsi</i></label>
                            <input type="text" class="form-control" placeholder="Masukkan provinsi mahasiswa" id="province" name="province"
                                required />
                        </div>


                        <div class="form-group">
                            <label for="status">Status</i></label>
                            <input type="text" class="form-control" placeholder="Masukkan status mahasiswa" id="status" name="status"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="flat">Flat</i></label>
                            <select class="form-control" id="flat" name="flat" required>
                                <option value="" selected>- Pilih -</option>
                                @foreach ($flats as $flat)
                                <option value="{{ $flat->flat_id }}">{{ $flat->name }}</option>
                                @endforeach

                            </select>

                        </div>

                        <div class="form-group">
                            <label for="kamar">Kamar</i></label>
                            <input type="text" class="form-control" placeholder="Masukkan kamar mahasiswa" id="kamar" name="kamar"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="semester">Semester</i></label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="" selected>- Pilih -</option>
                                @foreach ($semesters as $semester)
                                <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
                                @endforeach

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