<!-- Tab 1: Format 1 -->
<div class="tab-pane fade table-responsive" id="format1" role="tabpanel">

    <a href="#addnewformat1" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format1" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th data-priority="1">No</th>
                <th data-priority="2">Tahun</th>
                <th data-priority="3">Bulan</th>
                <th data-priority="4">Nama Ibu</th>
                <th data-priority="5">Nama Bapak</th>
                <th data-priority="6">Nama Bayi</th>
                <th data-priority="7">Tanggal Lahir</th>
                <th data-priority="8">Tanggal Meninggal Bayi</th>
                <th data-priority="9">Tanggal Meninggal Ibu</th>
                <th data-priority="10">Keterangan</th>
                <th data-priority="11">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $format1 as $sip1)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $sip1->tahun }}</td>
                <td>{{$sip1->bulan}}</td>
                <td>{{$sip1->nama_ibu}}</td>
                <td>{{$sip1->nama_bapak}}</td>
                <td>{{$sip1->nama_bayi}}</td>
                <td>{{ $sip1->tgl_lahir ? $sip1->tgl_lahir->format('d-m-Y') : '-' }}</td>
                <td>{{ $sip1->tgl_meninggal_ibu ? $sip1->tgl_meninggal_ibu->format('d-m-Y') : '-' }}</td>
                <td>{{ $sip1->tgl_meninggal_bayi ? $sip1->tgl_meninggal_bayi->format('d-m-Y') : '-' }}</td>
                <td>{{$sip1->keterangan ?? '-'}}</td>
                <td>
                    <a href="#edit{{$sip1->sip1_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                    <a href="#delete{{$sip1->sip1_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@foreach($format1 as $sip1)
<!-- Edit -->
<div class="modal fade" id="edit{{$sip1->sip1_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 1 - SIP</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip1.update', $sip1->sip1_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="sip1_id" value="{{ $sip1->sip1_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $sip1->posyandu_id }}" />

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control" placeholder="Masukkan tahun" id="tahun" name="tahun"
                                    value="{{ $sip1->tahun ?? '' }}" min="1900" max="2100" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" id="bulan" name="bulan" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="Januari" {{ ($sip1->bulan ?? '') == 'Januari' ? 'selected' : '' }}>Januari</option>
                                    <option value="Februari" {{ ($sip1->bulan ?? '') == 'Februari' ? 'selected' : '' }}>Februari</option>
                                    <option value="Maret" {{ ($sip1->bulan ?? '') == 'Maret' ? 'selected' : '' }}>Maret</option>
                                    <option value="April" {{ ($sip1->bulan ?? '') == 'April' ? 'selected' : '' }}>April</option>
                                    <option value="Mei" {{ ($sip1->bulan ?? '') == 'Mei' ? 'selected' : '' }}>Mei</option>
                                    <option value="Juni" {{ ($sip1->bulan ?? '') == 'Juni' ? 'selected' : '' }}>Juni</option>
                                    <option value="Juli" {{ ($sip1->bulan ?? '') == 'Juli' ? 'selected' : '' }}>Juli</option>
                                    <option value="Agustus" {{ ($sip1->bulan ?? '') == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                                    <option value="September" {{ ($sip1->bulan ?? '') == 'September' ? 'selected' : '' }}>September</option>
                                    <option value="Oktober" {{ ($sip1->bulan ?? '') == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                                    <option value="November" {{ ($sip1->bulan ?? '') == 'November' ? 'selected' : '' }}>November</option>
                                    <option value="Desember" {{ ($sip1->bulan ?? '') == 'Desember' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu"
                            value="{{ $sip1->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_bapak">Nama Bapak</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama bapak" id="nama_bapak" name="nama_bapak"
                            value="{{ $sip1->nama_bapak ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_bayi">Nama Bayi</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama bayi" id="nama_bayi" name="nama_bayi"
                                    value="{{ $sip1->nama_bayi ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                    value="{{ $sip1->tgl_lahir ? $sip1->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_meninggal_ibu">Tanggal Meninggal Ibu (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_meninggal_ibu" name="tgl_meninggal_ibu"
                                    value="{{ $sip1->tgl_meninggal_ibu ? $sip1->tgl_meninggal_ibu->format('Y-m-d') : '' }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_meninggal_bayi">Tanggal Meninggal Bayi (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_meninggal_bayi" name="tgl_meninggal_bayi"
                                    value="{{ $sip1->tgl_meninggal_bayi ? $sip1->tgl_meninggal_bayi->format('Y-m-d') : '' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" placeholder="Masukkan keterangan (opsional)" id="keterangan" name="keterangan" rows="3">{{ $sip1->keterangan ?? '' }}</textarea>
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
<div class="modal fade" id="delete{{ $sip1->sip1_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 1 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip1.delete', $sip1->sip1_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="sip1_id" value="{{ $sip1->sip1_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $sip1->nama_bayi }}</h2>
                        <p>Nama Ibu: {{ $sip1->nama_ibu }}</p>
                        <p>Nama Bapak: {{ $sip1->nama_bapak }}</p>
                        <p>{{ $sip1->tahun }} - {{ $sip1->bulan }}</p>
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
    // Set tanggal maksimal ke hari ini untuk semua input tanggal edit
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const tglLahirInputs = document.querySelectorAll('[name="tgl_lahir"]');
        const tglMeninggalIbuInputs = document.querySelectorAll('[name="tgl_meninggal_ibu"]');
        const tglMeninggalBayiInputs = document.querySelectorAll('[name="tgl_meninggal_bayi"]');

        tglLahirInputs.forEach(function(input) {
            input.setAttribute('max', today);
        });

        tglMeninggalIbuInputs.forEach(function(input) {
            input.setAttribute('max', today);
        });

        tglMeninggalBayiInputs.forEach(function(input) {
            input.setAttribute('max', today);
        });
    });
</script>
@endforeach