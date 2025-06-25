<!-- Edit -->
<div class="modal fade" id="edit{{$semester->semester_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Semester</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('semester.update') }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="semester_name">Nama Semester</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama semester" id="semester_name" name="semester_name"
                            required value="{{ $semester->semester_name }}" />
                    </div>
                    
                    <div class="form-group">
                            <label for="start_date">Tanggal Mulai</i></label>
                            <input type="date" class="form-control" placeholder="Masukkan tanggal mulai" id="start_date" name="start_date"
                               value="{{ \Carbon\Carbon::parse($semester->start_date)->format('Y-m-d') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</i></label>
                            <input type="date" class="form-control" placeholder="Masukkan tanggal selesai" id="end_date" name="end_date"
                            value="{{ \Carbon\Carbon::parse($semester->end_date)->format('Y-m-d') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="is_active">Is Active</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                            @php $actives = [0, 1] @endphp
                            @foreach ($actives as $active)
                            @php $selected = ($active == $semester->is_active) @endphp
                            <option value="{{ $active }}" @if ($selected) selected @endif>{{ $active }}</option>
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
<div class="modal fade" id="delete{{ $semester->semester_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

                <h4 class="modal-title "><span class="student_id">Delete Semester</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('semester.delete', $semester->semester_id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{$semester->semester_id}}</h2>
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