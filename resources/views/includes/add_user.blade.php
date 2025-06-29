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
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Masukkan username" id="username" name="username"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan password" id="password" name="password"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" selected>- Pilih -</option>
                                <option value="admin_desa">Admin Desa</option>
                                <option value="admin_kader">Admin Kader</option>
                                <option value="admin_rw">Admin RW</option>
                            </select>
                        </div>

                        <div class="form-group" id="rw_group" style="display: none;">
                            <label for="no_rw">Nomor RW</label>
                            <select class="form-control" id="no_rw" name="no_rw">
                                <option value="">- Pilih RW -</option>
                                @if(isset($rwList) && $rwList->count() > 0)
                                    @foreach($rwList as $rw)
                                        <option value="{{ $rw->no_rw }}">RW {{ $rw->no_rw }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group" id="posyandu_group" style="display: none;">
                            <label for="nama_posyandu">Nama Posyandu</label>
                            <select class="form-control" id="nama_posyandu" name="nama_posyandu">
                                <option value="">- Pilih Posyandu -</option>
                                @if(isset($posyanduList) && $posyanduList->count() > 0)
                                    @foreach($posyanduList as $posyandu)
                                        <option value="{{ $posyandu->nama_posyandu }}">{{ $posyandu->nama_posyandu }}</option>
                                    @endforeach
                                @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const rwGroup = document.getElementById('rw_group');
    const posyanduGroup = document.getElementById('posyandu_group');
    const rwSelect = document.getElementById('no_rw');
    const posyanduSelect = document.getElementById('nama_posyandu');

    function toggleDropdowns() {
        const selectedRole = roleSelect.value;
        
        // Hide all dropdowns first
        rwGroup.style.display = 'none';
        posyanduGroup.style.display = 'none';
        
        // Clear selections
        rwSelect.value = '';
        posyanduSelect.value = '';
        
        // Show appropriate dropdown based on role
        if (selectedRole === 'admin_rw') {
            rwGroup.style.display = 'block';
        } else if (selectedRole === 'admin_kader') {
            posyanduGroup.style.display = 'block';
        }
    }

    // Add event listener for role change
    roleSelect.addEventListener('change', toggleDropdowns);
    
    // Initialize on page load
    toggleDropdowns();
});
</script>
</div>