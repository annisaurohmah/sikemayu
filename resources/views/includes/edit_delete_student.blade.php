<!-- Edit -->
<div class="modal fade" id="edit{{$student->nim}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Mahasiswa</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('student.update') }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama mahasiswa" id="name" name="name"
                            required value="{{ $student->name }}" />
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM</i></label>
                        <input type="text" class="form-control" placeholder="Masukkan NIM mahasiswa" id="nim" name="nim"
                            required value="{{ $student->nim }}" />
                    </div>
                    <div class="form-group">
                        <label for="name">Agama</label>
                        <select class="form-control" id="religion" name="religion" required value="{{ $student->religion }}">
                            @php $religions = ["Islam", "Protestan", "Katolik", "Hindu", "Buddha", "Konghucu"] @endphp
                            @foreach ($religions as $religion)
                            @php $selected = ($religion == $student->religion) @endphp
                            <option value="{{ $religion }}" @if ($selected) selected @endif>{{ $religion }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Program Studi</i></label>
                        <input type="text" class="form-control" placeholder="Masukkan prodi mahasiswa" id="prodi" name="prodi"
                            required value="{{ $student->prodi }}" />
                    </div>

                    <div class="form-group">
                        <label for="province">Provinsi</i></label>
                        <input type="text" class="form-control" placeholder="Masukkan provinsi mahasiswa" id="province" name="province"
                            required value="{{ $student->province }}" />
                    </div>


                    <div class="form-group">
                        <label for="status">Status</i></label>
                        <input type="text" class="form-control" placeholder="Masukkan status mahasiswa" id="status" name="status"
                            required value="{{ $student->status }}" />
                    </div>

                    <div class="form-group">
                        <label for="flat">Flat</label>
                        <select class="form-control" id="flat" name="flat" required>
                            
                            @foreach ($flats as $flat)
                            @php $selected = ($flat->flat_id == $student->flat) @endphp
                            <option value="{{ $flat->flat_id }}" @if ($selected) selected @endif>{{ $flat->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="kamar">Kamar</i></label>
                        <input type="text" class="form-control" placeholder="Masukkan kamar mahasiswa" id="kamar" name="kamar" value="{{ $student->kamar }}"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</i></label>
                        <select class="form-control" id="semester" name="semester" required>
                            @foreach ($semesters as $semester)
                            @php $selected = ($semester->semester_id == $student->semester) @endphp
                            <option value="{{ $semester->semester_id }}" @if ($selected) selected @endif>{{ $semester->semester_name }}</option>
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
<div class="modal fade" id="delete{{ $student->mahasiswa_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

                <h4 class="modal-title "><span class="student_id">Delete Mahasiswa</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('student.delete', $student->mahasiswa_id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{$student->nim}}</h2>
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