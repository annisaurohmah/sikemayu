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
                        <select class="form-control" id="role_edit_{{ $user->user_id }}" name="role" required>
                            <option value="" selected>- Pilih -</option>
                            <option value="admin_desa" {{ $user->role == 'admin_desa' ? 'selected' : '' }}>Admin Desa</option>
                            <option value="admin_kader" {{ $user->role == 'admin_kader' ? 'selected' : '' }}>Admin Kader</option>
                            <option value="admin_rw" {{ $user->role == 'admin_rw' ? 'selected' : '' }}>Admin RW</option>
                        </select>
                    </div>

                    <div class="form-group" id="rw_group_edit_{{ $user->user_id }}" @if($user->role == 'admin_rw') style="display: block;" @else style="display: none;" @endif>
                        <label for="no_rw">Nomor RW</label>
                        <select class="form-control" id="no_rw_edit_{{ $user->user_id }}" name="no_rw">
                            <option value="">- Pilih RW -</option>
                            @if(isset($rwList) && $rwList->count() > 0)
                                @foreach($rwList as $rw)
                                    <option value="{{ $rw->no_rw }}" {{ $user->no_rw == $rw->no_rw ? 'selected' : '' }}>RW {{ $rw->no_rw }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group" id="posyandu_group_edit_{{ $user->user_id }}" @if($user->role == 'admin_kader') style="display: block;" @else style="display: none;" @endif>
                        <label for="nama_posyandu">Nama Posyandu</label>
                        <select class="form-control" id="nama_posyandu_edit_{{ $user->user_id }}" name="nama_posyandu">
                            <option value="">- Pilih Posyandu -</option>
                            @if(isset($posyanduList) && $posyanduList->count() > 0)
                                @foreach($posyanduList as $posyandu)
                                    <option value="{{ $posyandu->nama_posyandu }}" {{ $user->nama_posyandu == $posyandu->nama_posyandu ? 'selected' : '' }}>{{ $posyandu->nama_posyandu }}</option>
                                @endforeach
                            @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userId = '{{ $user->user_id }}';
    const roleSelect = document.getElementById('role_edit_' + userId);
    const rwGroup = document.getElementById('rw_group_edit_' + userId);
    const posyanduGroup = document.getElementById('posyandu_group_edit_' + userId);
    const rwSelect = document.getElementById('no_rw_edit_' + userId);
    const posyanduSelect = document.getElementById('nama_posyandu_edit_' + userId);

    function toggleEditDropdowns() {
        if (!roleSelect) return;
        
        const selectedRole = roleSelect.value;
        
        // Hide all dropdowns first
        if (rwGroup) rwGroup.style.display = 'none';
        if (posyanduGroup) posyanduGroup.style.display = 'none';
        
        // Show appropriate dropdown based on role
        if (selectedRole === 'admin_rw') {
            if (rwGroup) rwGroup.style.display = 'block';
            // Clear posyandu if switching to RW
            if (posyanduSelect) posyanduSelect.value = '';
        } else if (selectedRole === 'admin_kader') {
            if (posyanduGroup) posyanduGroup.style.display = 'block';
            // Clear RW if switching to Kader
            if (rwSelect) rwSelect.value = '';
        } else if (selectedRole === 'admin_desa') {
            // Clear both if admin_desa
            if (rwSelect) rwSelect.value = '';
            if (posyanduSelect) posyanduSelect.value = '';
        }
    }

    // Add event listener for role change
    if (roleSelect) {
        roleSelect.addEventListener('change', toggleEditDropdowns);
    }
});
</script>