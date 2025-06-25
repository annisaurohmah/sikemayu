<!-- Edit -->
<div class="modal fade" id="edit{{$activity->activity_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Kegiatan</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('nonrutin.update') }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label for="activity_id">ID</label>
                        <input type="text" class="form-control" id="activity_id" name="activity_id" readonly
                            value="{{ $activity->activity_id }}" />
                    </div>


                    <div class="form-group">
                        <label for="name">Nama Kegiatan</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama kegiatan" id="name" name="name" value="{{ $activity->name }}"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">-- Pilih --</option>
                            @php $categories = ["Seminar", "Literasi", "Bintal", "Lainnya"] @endphp
                            @foreach ($categories as $category)
                            @php $selected = ($activity->category == $category) @endphp
                            <option value="{{ $category }}" @if ($selected) selected @endif>{{ $category }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" placeholder="Masukkan tanggal kegiatan" id="date" name="date"
                            value="{{ \Carbon\Carbon::parse($activity->date)->format('Y-m-d') }}" required />
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
<div class="modal fade" id="delete{{ $activity->activity_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

                <h4 class="modal-title "><span class="student_id">Delete Kegiatan</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('nonrutin.delete', $activity->activity_id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{$activity->activity}}</h2>
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