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
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="name">ID</label>
                        <input type="text" class="form-control"  id="user_id" name="user_id" readonly
                        value="{{ $user->user_id }}" />
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Pengguna</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama pengguna" id="name" name="name" value="{{ $user->name }}"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</i></label>
                        <input type="email" class="form-control" placeholder="Masukkan email pengguna" id="email" name="email" value="{{ $user->email }}"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="Password">Password</i></label>
                        <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" id="password" name="password"
                                />
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            @php $roles = ['super_admin', 'admin', 'komandan', 'staff_kerohanian_islam', 'staff_kerohanian_protestan', 'staff_kerohanian_katolik', 'staff_kerohanian_hindu_buddha', 'staff_konsumsi', 'guest', 'kepatuhan_internal'] @endphp
                            @foreach ($roles as $role)
                            @php $selected = ($role == $user->role) @endphp
                            <option value="{{ $role }}" @if ($selected) selected @endif>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="flat">Flat (tersimpan hanya untuk Komandan dan Staff)</label>
                        <select class="form-control" id="flat_id" name="flat" required>
                            @foreach ($flats as $flat)
                            @php $selected = ($flat->name == $user->flat_name) @endphp
                            <option value="{{ $flat->flat_id }}" @if ($selected) selected @endif>{{ $flat->name }}</option>
                            @endforeach
                        </select>
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
                <form class="form-horizontal" method="POST" action="{{ route('user.delete', $user->user_id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{$user->name}}</h2>
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