<!-- Tab 2: Format 2 -->
<div class="tab-pane fade table-responsive" id="format2" role="tabpanel">

    <a href="#addnewformat2" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format2" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Bayi</th>
                <th rowspan="2">Tanggal Lahir</th>
                <th rowspan="2">BBL KG</th>
                <th colspan="2" class="text-center">Nama</th>
                <th rowspan="2">Kelompok Dasawisma</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (TB/BB)</th>
                <th colspan="6" class="text-center">Pemberian ASI</th>
                <th colspan="4" class="text-center">Pelayanan</th>
                <th colspan="8" class="text-center">Imunisasi</th>
                <th rowspan="2">Tanggal Bayi Meninggal</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Ayah</th>
                <th>Ibu</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
                @endforeach
                @foreach(['E1','E2','E3','E4','E5','E6'] as $e)
                <th>{{ $e }}</th>
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
            @foreach($bayiList as $index => $bayi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $bayi->nama_bayi }}</td>
                <td>{{ \Carbon\Carbon::parse($bayi->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{ $bayi->bbl_kg }}</td>
                <td>{{ $bayi->nama_ayah }}</td>
                <td>{{ $bayi->nama_ibu }}</td>
                <td>{{ $bayi->dasawisma->nama_dasawisma ?? '-' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$bayi->penimbangan->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->tb_hasil_penimbangan }}/{{ $dataTimbang->bb_hasil_penimbangan }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['E1','E2','E3','E4','E5','E6'] as $jenis)
                    @php
                    $asi = $bayi->asi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $asi ? \Carbon\Carbon::parse($asi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach

                    @foreach(['Vitamin A','Oralit','HB Nol','BCG'] as $jenis)
                    @php
                    $pelayanan = $bayi->pelayanan->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $pelayanan ? \Carbon\Carbon::parse($pelayanan->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['POLIO I','POLIO II','POLIO III','POLIO IV','DPT/HB I','DPT/HB II','DPT/HB III','Campak'] as $jenis)
                    @php
                    $imunisasi = $bayi->imunisasi->firstWhere('jenis', $jenis);
                    @endphp
                    <td>{{ $imunisasi ? \Carbon\Carbon::parse($imunisasi->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach
                    <td>{{ $bayi->keteranganBalita ? \Carbon\Carbon::parse($bayi->keteranganBalita->tanggal_meninggal)->format('d-m-Y') : '' }}</td>
                    <td>{{ $bayi->keteranganBalita->catatan ?? '' }}</td>
                    <td>
                        <a href="#editformat2{{$bayi->bayi_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat" onclick="console.log('Edit clicked for bayi_id: {{$bayi->bayi_id}}')"><i class='fa fa-edit'></i></a>
                        <a href="#deleteformat2{{$bayi->bayi_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat" onclick="console.log('Delete clicked for bayi_id: {{$bayi->bayi_id}}')"><i class='fa fa-trash'></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@foreach($bayiList as $bayi)
<!-- Edit Format 2 -->
<div class="modal fade" id="editformat2{{ $bayi->bayi_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 2 - SIP (Bayi)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip2.update', $bayi->bayi_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bayi_id" value="{{ $bayi->bayi_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $bayi->posyandu_id }}" />

                    <div class="form-group">
                        <label for="nama_bayi_edit">Nama Bayi</label>
                        <select class="form-control select2" id="nama_bayi_edit_{{$bayi->bayi_id}}" name="nama_bayi" required>
                            <option value="">Pilih Bayi</option>
                            
                            <!-- Tampilkan bayi yang sedang diedit -->
                            <option value="{{ $bayi->nama_bayi }}" selected>
                                {{ $bayi->nama_bayi }} (Data Saat Ini)
                            </option>
                            
                            <!-- Tampilkan pilihan bayi lain yang belum terdaftar -->
                            @if(isset($bayiList_master))
                            @foreach($bayiList_master as $bayi_master)
                            <option value="{{ $bayi_master->nama_lengkap }}"
                                data-nik="{{ $bayi_master->nik }}"
                                data-tgl="{{ $bayi_master->tanggal_lahir }}"
                                data-orangtua="{{ $bayi_master->nama_lengkap_ortu }}">
                                {{ $bayi_master->nama_lengkap }} - {{ $bayi_master->nama_lengkap_ortu }} ({{ $bayi_master->tanggal_lahir ? $bayi_master->tanggal_lahir->format('d-m-Y') : '' }})
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <small class="form-text text-muted">Data saat ini terpilih. Anda dapat mengganti dengan bayi lain dari daftar yang tersedia.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir_edit">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir_edit_{{$bayi->bayi_id}}" name="tgl_lahir"
                                    value="{{ $bayi->tgl_lahir ? $bayi->tgl_lahir->format('Y-m-d') : '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bbl_kg_edit">Berat Badan Lahir (kg)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir"
                                    id="bbl_kg_edit_{{$bayi->bayi_id}}" name="bbl_kg" value="{{ $bayi->bbl_kg ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_ayah_edit">Nama Ayah</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ayah"
                            id="nama_ayah_edit_{{$bayi->bayi_id}}" name="nama_ayah" value="{{ $bayi->nama_ayah ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="nama_ibu_edit">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu"
                            id="nama_ibu_edit_{{$bayi->bayi_id}}" name="nama_ibu" value="{{ $bayi->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id_edit">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id_edit_{{$bayi->bayi_id}}" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                            @foreach($dasawismaList as $dasawisma)
                            <option value="{{ $dasawisma->dasawisma_id }}" {{ ($bayi->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                {{ $dasawisma->nama_dasawisma }}
                            </option>
                            @endforeach
                            @endif
                        </select>
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
                                        $penimbangan = $bayi->penimbangan->firstWhere('bulan', $i);
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

                    <!-- Section Pemberian ASI -->
                    <hr>
                    <h6 class="text-success"><i class="fa fa-heart"></i> Data Pemberian ASI</h6>
                    <div class="row">
                        @foreach(['E1', 'E2', 'E3', 'E4', 'E5', 'E6'] as $jenis)
                            @php
                                $asi = $bayi->asi->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-4 mb-3">
                                <label for="asi_{{ $jenis }}_{{$bayi->bayi_id}}">{{ $jenis }}</label>
                                <input type="date" class="form-control form-control-sm" 
                                       id="asi_{{ $jenis }}_{{$bayi->bayi_id}}" 
                                       name="asi[{{ $jenis }}]" 
                                       value="{{ $asi ? $asi->tanggal_diberikan->format('Y-m-d') : '' }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Section Pelayanan -->
                    <hr>
                    <h6 class="text-info"><i class="fa fa-medkit"></i> Data Pelayanan</h6>
                    <div class="row">
                        @foreach(['Vitamin A', 'Oralit', 'HB Nol', 'BCG'] as $jenis)
                            @php
                                $pelayanan = $bayi->pelayanan->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label for="pelayanan_{{ str_replace(' ', '_', $jenis) }}_{{$bayi->bayi_id}}">{{ $jenis }}</label>
                                <input type="date" class="form-control form-control-sm" 
                                       id="pelayanan_{{ str_replace(' ', '_', $jenis) }}_{{$bayi->bayi_id}}" 
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
                                $imunisasi = $bayi->imunisasi->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label for="imunisasi_{{ str_replace(['/', ' '], '_', $jenis) }}_{{$bayi->bayi_id}}">{{ $jenis }}</label>
                                <input type="date" class="form-control form-control-sm" 
                                       id="imunisasi_{{ str_replace(['/', ' '], '_', $jenis) }}_{{$bayi->bayi_id}}" 
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
                                <label for="tanggal_meninggal_{{$bayi->bayi_id}}">Tanggal Bayi Meninggal</label>
                                <input type="date" class="form-control" 
                                       id="tanggal_meninggal_{{$bayi->bayi_id}}" 
                                       name="tanggal_meninggal" 
                                       value="{{ $bayi->keteranganBalita ? $bayi->keteranganBalita->tanggal_meninggal->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan_{{$bayi->bayi_id}}">Catatan</label>
                                <textarea class="form-control" 
                                          id="catatan_{{$bayi->bayi_id}}" 
                                          name="catatan" 
                                          rows="3" 
                                          placeholder="Masukkan catatan jika ada">{{ $bayi->keteranganBalita->catatan ?? '' }}</textarea>
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

<!-- Delete Format 2 -->
<div class="modal fade" id="deleteformat2{{ $bayi->bayi_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="align-items: center">
                <h4 class="modal-title"><span class="student_id">Delete Data Format 2 - SIP (Bayi)</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip2.delete', $bayi->bayi_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="bayi_id" value="{{ $bayi->bayi_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $bayi->nama_bayi }}</h2>
                        <p>Nama Ayah: {{ $bayi->nama_ayah }}</p>
                        <p>Nama Ibu: {{ $bayi->nama_ibu }}</p>
                        <p>Tanggal Lahir: {{ $bayi->tgl_lahir ? $bayi->tgl_lahir->format('d-m-Y') : '-' }}</p>
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
        console.log('Format 2 modal script loaded for bayi_id: {{$bayi->bayi_id}}');

        // Initialize Select2 untuk edit modal ini
        $('#nama_bayi_edit_{{$bayi->bayi_id}}').select2({
            placeholder: "Pilih atau ketik untuk mencari...",
            allowClear: true,
            width: '100%'
        });

        // Auto-fill data ketika bayi dipilih di edit modal
        $('#nama_bayi_edit_{{$bayi->bayi_id}}').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const tglLahir = selectedOption.data('tgl');
            const namaOrangtua = selectedOption.data('orangtua');

            if (tglLahir) {
                const date = new Date(tglLahir);
                const formattedDate = date.toISOString().split('T')[0];
                $('#tgl_lahir_edit_{{$bayi->bayi_id}}').val(formattedDate);
            }

            if (namaOrangtua) {
                const orangtuaParts = namaOrangtua.split('/');
                if (orangtuaParts.length >= 2) {
                    $('#nama_ayah_edit_{{$bayi->bayi_id}}').val(orangtuaParts[0].trim());
                    $('#nama_ibu_edit_{{$bayi->bayi_id}}').val(orangtuaParts[1].trim());
                } else {
                    // Jika hanya satu nama, masukkan ke nama ayah dan kosongkan nama ibu
                    $('#nama_ayah_edit_{{$bayi->bayi_id}}').val(namaOrangtua);
                    $('#nama_ibu_edit_{{$bayi->bayi_id}}').val('');
                }
            }
        });

        // Set tanggal maksimal ke hari ini untuk semua input date
        const today = new Date().toISOString().split('T')[0];
        
        // Set max date untuk semua input date di modal ini
        $('input[type="date"]', '#editformat2{{$bayi->bayi_id}}').attr('max', today);
        
        // Validasi tanggal tidak boleh masa depan
        $('input[type="date"]', '#editformat2{{$bayi->bayi_id}}').on('change', function() {
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