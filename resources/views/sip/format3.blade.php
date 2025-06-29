<!-- Tab 3: Format 3 -->
<div class="tab-pane fade table-responsive" id="format3" role="tabpanel">

    <a href="#addnewformat3" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format3" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>                                                      
                <th rowspan="2">Nama Balita</th>
                <th rowspan="2">Tanggal Lahir</th>
                <th rowspan="2">BBL KG</th>
                <th colspan="2" class="text-center">Nama</th>
                <th rowspan="2">Kelompok Dasawisma</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (TB/BB)</th>
                <th colspan="4" class="text-center">Pelayanan</th>
                <th colspan="8" class="text-center">Imunisasi</th>
                <th rowspan="2">Tanggal Balita Meninggal</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Ayah</th>
                <th>Ibu</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
                @endforeach
    
                @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $p)
                <th>{{ $p }}</th>
                @endforeach
                @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $i)
                <th>{{ $i }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($balitaList as $index => $balita)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $balita->nama_balita }}</td>
                <td>{{ \Carbon\Carbon::parse($balita->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{ $balita->bbl_kg }}</td>
                <td>{{ $balita->nama_ayah }}</td>
                <td>{{ $balita->nama_ibu }}</td>
                <td>{{ $balita->dasawisma->nama_dasawisma ?? '-' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$balita->penimbangan->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->tb_hasil_penimbangan }}/{{ $dataTimbang->bb_hasil_penimbangan }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $jenis)
                    @php
                    $pelayanan = $balita->pelayanan->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $pelayanan ? \Carbon\Carbon::parse($pelayanan->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $jenis)
                    @php
                    $imunisasi = $balita->imunisasi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $imunisasi ? \Carbon\Carbon::parse($imunisasi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach
                        <td>{{ $balita->keteranganBalita ? \Carbon\Carbon::parse($balita->keteranganBalita->tanggal_meninggal)->format('d-m-Y') : '' }}</td>
                    <td>{{ $balita->keteranganBalita->catatan ?? '' }}</td>
                    <td>
                        <a href="#editformat3{{$balita->balita_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                        <a href="#deleteformat3{{$balita->balita_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($balitaList as $balita)
<!-- Edit Format 3 -->
<div class="modal fade" id="editformat3{{$balita->balita_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 3 - SIP (Balita)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip3.update', $balita->balita_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="balita_id" value="{{ $balita->balita_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $balita->posyandu_id }}" />
                    
                    <div class="form-group">
                        <label for="nama_balita_edit">Nama Balita</label>
                        <select class="form-control select2" id="nama_balita_edit_{{$balita->balita_id}}" name="nama_balita" required>
                            <option value="">Pilih Balita</option>
                            
                            <!-- Tampilkan balita yang sedang diedit -->
                            <option value="{{ $balita->nama_balita }}" selected>
                                {{ $balita->nama_balita }} (Data Saat Ini)
                            </option>
                            
                            <!-- Tampilkan pilihan balita lain yang belum terdaftar -->
                            @if(isset($balitaList_master))
                                @foreach($balitaList_master as $balita_master)
                                    <option value="{{ $balita_master->nama_lengkap }}" 
                                        data-nik="{{ $balita_master->nik }}" 
                                        data-tgl="{{ $balita_master->tanggal_lahir }}" 
                                        data-orangtua="{{ $balita_master->nama_lengkap_ortu }}">
                                        {{ $balita_master->nama_lengkap }} - {{ $balita_master->nama_lengkap_ortu }} ({{ $balita_master->tanggal_lahir ? $balita_master->tanggal_lahir->format('d-m-Y') : '' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="form-text text-muted">Data saat ini terpilih. Anda dapat mengganti dengan balita lain dari daftar yang tersedia.</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Informasi:</strong> Tanggal lahir akan diambil otomatis dari data master anak berdasarkan nama yang dipilih.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bbl_kg_edit">Berat Badan Lahir (kg)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" 
                                id="bbl_kg_edit_{{$balita->balita_id}}" name="bbl_kg" value="{{ $balita->bbl_kg ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dasawisma_id_edit">Dasawisma</label>
                                <select class="form-control" id="dasawisma_id_edit_{{$balita->balita_id}}" name="dasawisma_id" required>
                                    <option value="">Pilih Dasawisma</option>
                                    @if(isset($dasawismaList))
                                        @foreach($dasawismaList as $dasawisma)
                                            <option value="{{ $dasawisma->dasawisma_id }}" {{ ($balita->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                                {{ $dasawisma->nama_dasawisma }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah_edit">Nama Ayah</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ayah" 
                        id="nama_ayah_edit_{{$balita->balita_id}}" name="nama_ayah" value="{{ $balita->nama_ayah ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu_edit">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu" 
                        id="nama_ibu_edit_{{$balita->balita_id}}" name="nama_ibu" value="{{ $balita->nama_ibu ?? '' }}" required />
                    </div>

                    <!-- Section Data Penimbangan Bulanan -->
                    <hr>
                    <h6 class="text-primary"><i class="fa fa-weight"></i> Data Penimbangan Bulanan</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Tinggi Badan (cm)</th>
                                    <th class="text-center">Berat Badan (kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                @for($i = 1; $i <= 12; $i++)
                                    @php
                                        $penimbangan = $balita->penimbangan->firstWhere('bulan', $i);
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $bulanNames[$i-1] }}</strong></td>
                                        <td>
                                            <input type="number" step="0.1" class="form-control form-control-sm" 
                                                   name="tb_penimbangan[{{ $i }}]" 
                                                   value="{{ $penimbangan->tb_hasil_penimbangan ?? '' }}" 
                                                   placeholder="TB (cm)">
                                        </td>
                                        <td>
                                            <input type="number" step="0.1" class="form-control form-control-sm" 
                                                   name="bb_penimbangan[{{ $i }}]" 
                                                   value="{{ $penimbangan->bb_hasil_penimbangan ?? '' }}" 
                                                   placeholder="BB (kg)">
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Section Pelayanan -->
                    <hr>
                    <h6 class="text-info"><i class="fa fa-medkit"></i> Data Pelayanan</h6>
                    <div class="row">
                        @foreach(['Vitamin A', 'Oralit', 'HB Nol', 'BCG'] as $jenis)
                            @php
                                $pelayanan = $balita->pelayanan->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label for="pelayanan_{{ str_replace(' ', '_', $jenis) }}_{{$balita->balita_id}}">{{ $jenis }}</label>
                                <input type="date" class="form-control form-control-sm" 
                                       id="pelayanan_{{ str_replace(' ', '_', $jenis) }}_{{$balita->balita_id}}" 
                                       name="pelayanan[{{ $jenis }}]" 
                                       value="{{ $pelayanan ? $pelayanan->tanggal_diberikan->format('Y-m-d') : '' }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Section Imunisasi -->
                    <hr>
                    <h6 class="text-warning"><i class="fa fa-shield"></i> Data Imunisasi</h6>
                    <div class="row">
                        @foreach(['POLIO I', 'POLIO II', 'POLIO III', 'POLIO IV', 'DPT/HB I', 'DPT/HB II', 'DPT/HB III', 'Campak'] as $jenis)
                            @php
                                $imunisasi = $balita->imunisasi->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label for="imunisasi_{{ str_replace(['/', ' '], '_', $jenis) }}_{{$balita->balita_id}}">{{ $jenis }}</label>
                                <input type="date" class="form-control form-control-sm" 
                                       id="imunisasi_{{ str_replace(['/', ' '], '_', $jenis) }}_{{$balita->balita_id}}" 
                                       name="imunisasi[{{ $jenis }}]" 
                                       value="{{ $imunisasi ? $imunisasi->tanggal_diberikan->format('Y-m-d') : '' }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Section Keterangan -->
                    <hr>
                    <h6 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Keterangan</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_meninggal_{{$balita->balita_id}}">Tanggal Balita Meninggal</label>
                                <input type="date" class="form-control" 
                                       id="tanggal_meninggal_{{$balita->balita_id}}" 
                                       name="tanggal_meninggal" 
                                       value="{{ $balita->keteranganBalita ? $balita->keteranganBalita->tanggal_meninggal->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan_{{$balita->balita_id}}">Catatan</label>
                                <textarea class="form-control" 
                                          id="catatan_{{$balita->balita_id}}" 
                                          name="catatan" 
                                          rows="3" 
                                          placeholder="Masukkan catatan jika ada">{{ $balita->keteranganBalita->catatan ?? '' }}</textarea>
                            </div>
                        </div>
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

<!-- Delete Format 3 -->
<div class="modal fade" id="deleteformat3{{ $balita->balita_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="align-items: center">
                <h4 class="modal-title"><span class="student_id">Delete Data Format 3 - SIP (Balita)</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip3.delete', $balita->balita_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="balita_id" value="{{ $balita->balita_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $balita->nama_balita }}</h2>
                        <p>Nama Ayah: {{ $balita->nama_ayah ?? '-' }}</p>
                        <p>Nama Ibu: {{ $balita->nama_ibu ?? '-' }}</p>
                        <p>Tanggal Lahir: {{ $balita->tgl_lahir ? $balita->tgl_lahir->format('d-m-Y') : '-' }}</p>
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
$(document).ready(function() {
    console.log('Format 3 modal script loaded for balita_id: {{$balita->balita_id}}');

    // Initialize Select2 untuk edit modal ini
    $('#nama_balita_edit_{{$balita->balita_id}}').select2({
        placeholder: "Pilih atau ketik untuk mencari...",
        allowClear: true,
        width: '100%'
    });

    // Auto-fill data ketika balita dipilih di edit modal
    $('#nama_balita_edit_{{$balita->balita_id}}').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const namaOrangtua = selectedOption.data('orangtua');
        
        if (namaOrangtua) {
            // Split nama orangtua jika ada format "Nama Ayah / Nama Ibu"
            const orangtuaParts = namaOrangtua.split('/');
            if (orangtuaParts.length >= 2) {
                $('#nama_ayah_edit_{{$balita->balita_id}}').val(orangtuaParts[0].trim());
                $('#nama_ibu_edit_{{$balita->balita_id}}').val(orangtuaParts[1].trim());
            } else {
                // Jika hanya satu nama, masukkan ke nama ayah dan kosongkan nama ibu
                $('#nama_ayah_edit_{{$balita->balita_id}}').val(namaOrangtua);
                $('#nama_ibu_edit_{{$balita->balita_id}}').val('');
            }
        }
    });

    // Set tanggal maksimal ke hari ini untuk semua input date
    const today = new Date().toISOString().split('T')[0];
    
    // Set max date untuk semua input date di modal ini
    $('input[type="date"]', '#editformat3{{$balita->balita_id}}').attr('max', today);
    
    // Validasi tanggal tidak boleh masa depan
    $('input[type="date"]', '#editformat3{{$balita->balita_id}}').on('change', function() {
        const selectedDate = new Date($(this).val());
        const today = new Date();
        today.setHours(23, 59, 59, 999);
        
        if (selectedDate > today) {
            alert('Tanggal tidak boleh di masa depan!');
            $(this).val('');
        }
    });
});
</script>
@endforeach