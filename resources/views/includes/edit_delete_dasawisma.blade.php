<!-- Edit -->
<div class="modal fade" id="edit{{$dasawisma->dasawisma_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Dasawisma</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('dasawisma.update') }}">
                    @csrf
                    <input type="hidden" name="dasawisma_id" value="{{ $dasawisma->dasawisma_id }}" />
                    
                    <div class="form-group">
                        <label for="nama_dasawisma">Nama Dasawisma</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama dasawisma" id="nama_dasawisma" name="nama_dasawisma" 
                        value="{{ $dasawisma->nama_dasawisma ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="alamat_dasawisma">Alamat Dasawisma</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan alamat dasawisma" id="alamat_dasawisma" name="alamat_dasawisma">{{ $dasawisma->alamat_dasawisma ?? '' }}</textarea>
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
<div class="modal fade" id="delete{{ $dasawisma->dasawisma_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Dasawisma</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('dasawisma.delete') }}">
                    @csrf
                    <input type="hidden" name="dasawisma_id" value="{{ $dasawisma->dasawisma_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $dasawisma->nama_dasawisma }}</h2>
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