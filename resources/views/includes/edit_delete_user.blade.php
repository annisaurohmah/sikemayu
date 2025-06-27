<!-- Edit -->
<div class="modal fade" id="edit{{$user->user_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Pengguna</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('user.update') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" placeholder="Masukkan username" id="username" name="username" 
                        value="{{ $user->username ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" id="password" name="password" />
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" selected>- Pilih -</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kader" {{ $user->role == 'kader' ? 'selected' : '' }}>Kader</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_rw">Nomor RW</label>
                        <input type="text" class="form-control" placeholder="Contoh: 01" id="no_rw" name="no_rw" 
                        value="{{ $user->no_rw ?? '' }}" />
                    </div>

                    <div class="form-group">
                        <label for="nama_posyandu">Nama Posyandu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama posyandu" id="nama_posyandu" name="nama_posyandu" 
                        value="{{ $user->nama_posyandu ?? '' }}" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                            Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete{{ $user->user_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Pengguna</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('user.delete') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $user->username ?? 'User ID: ' . $user->user_id }}</h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>