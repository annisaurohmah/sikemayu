<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Pengguna Baru</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>


            <div class="modal-body">
                <!-- Log on to codeastro.com for more projects! -->

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pengguna</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama pengguna" id="name" name="name"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</i></label>
                            <input type="email" class="form-control" placeholder="Masukkan email pengguna" id="email" name="email"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="Password">Password</i></label>
                            <input type="password" class="form-control" placeholder="Masukkan password pengguna" id="password" name="password"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" selected>- Pilih -</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="komandan">Komandan</option>
                                <option value="staff_kerohanian_islam">Staff Kerohanian Islam</option>
                                <option value="staff_kerohanian_protestan">Staff Kerohanian Protestan</option>
                                <option value="staff_kerohanian_katolik">Staff Kerohanian Katolik</option>
                                <option value="staff_kerohanian_hindu">Staff Kerohanian Hindu</option>
                                <option value="staff_konsumsi">Staff Konsumsi</option>
                                <option value="kepatuhan_internal">Kepatuhan Internal</option>

                                <option value="guest">Guest</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="flat">Flat (tersimpan hanya untuk Komandan dan Staff)</i></label>
                            <select class="form-control" id="flat" name="flat" required>
                                <option value="" selected>- Pilih -</option>
                                @foreach ($flats as $flat)
                                <option value="{{ $flat->flat_id }}">{{ $flat->name }}</option>
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