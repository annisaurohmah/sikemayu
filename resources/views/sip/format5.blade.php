<!-- Tab 3: Format 3 -->
<div class="tab-pane fade table-responsive" id="format5" role="tabpanel">

    <a href="#addnewformat5" data-toggle="modal" class="btn btn-success btn-sm btn-flat mt-2 mb-2"><i class="mdi mdi-plus mr-2"></i>Tambah Data</a>

    <table id="table-format5" class="table table-striped table-hover table-bordered dt-responsive nowrap">
        <thead class="thead-dark">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Ibu</th>
                <th rowspan="2">Umur</th>
                <th rowspan="2">Alamat Kelompok Dasawisma</th>
                <th colspan="2" class="text-center">Pendaftaran</th>
                <th rowspan="2">Hamil Ke</th>
                <th rowspan="2">LILA</th>
                <th rowspan="2">PMT Pemulihan</th>
                <th colspan="12" class="text-center">Hasil Penimbangan (BB)</th>
                <th colspan="3" class="text-center">Tablet Tambah Darah (BKS)</th>
                <th colspan="5" class="text-center">Imunisasi</th>
                <th rowspan="2">Vitamin A</th>
                <th rowspan="2">Catatan</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Umur Kelahiran (Pekan)</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'] as $bln)
                <th>{{ $bln }}</th>
                @endforeach

                @foreach(['I','II','III'] as $p)
                <th>{{ $p }}</th>
                @endforeach

                @foreach(['I', 'II', 'III', 'IV', 'V'] as $i)
                <th>{{ $i }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($ibuHamilList as $index => $ibuHamil)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ibuHamil->nama_ibu }}</td>
                <td>{{ $ibuHamil->umur }}</td>
                <td>{{ $ibuHamil->alamat_kelompok }}</td>
                <td>{{ $ibuHamil->tanggal_pendaftaran ? \Carbon\Carbon::parse($ibuHamil->tanggal_pendaftaran)->format('d-m-Y') : '-' }}</td>
                <td>{{ $ibuHamil->umur_kehamilan }}</td>
                <td>{{ $ibuHamil->hamil_ke }}</td>
                <td>{{ $ibuHamil->ukuran_lila ? $ibuHamil->ukuran_lila . ' cm' : '-' }}</td>
                <td>{{ $ibuHamil->pmt_pemulihan ? 'Ya' : 'Tidak' }}</td>

                @for($i = 1; $i <= 12; $i++)
                    @php
                    $dataTimbang=$ibuHamil->penimbanganIbuHamil->firstWhere('bulan', $i);
                    @endphp
                    <td>
                        @if($dataTimbang)
                        {{ $dataTimbang->berat_badan ? $dataTimbang->berat_badan . ' kg' : '-' }}
                        @else
                        -
                        @endif
                    </td>
                    @endfor


                    @foreach(['I','II','III'] as $tablet)
                    @php
                    $tabletTambahDarah = $ibuHamil->tabletTambahDarah->firstWhere('jenis', $tablet);
                    @endphp
                    <td>{{ $tabletTambahDarah ? \Carbon\Carbon::parse($tabletTambahDarah->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach


                    @foreach(['I', 'II', 'III', 'IV', 'V'] as $imun)
                    @php
                    $imunisasittIbuHamil = $ibuHamil->imunisasittIbuHamil->firstWhere('jenis', $imun);
                    @endphp
                    <td>{{ $imunisasittIbuHamil ? \Carbon\Carbon::parse($imunisasittIbuHamil->tanggal_diberikan)->format('d-m-Y') : '' }}</td>
                    @endforeach

                    @php
                    $vitaminData = $ibuHamil->vitaminIbuHamil->first();
                    @endphp
                    <td>{{ $vitaminData ? \Carbon\Carbon::parse($vitaminData->tanggal_pemberian)->format('d-m-Y') : '' }}</td>
                    <td>{{ $ibuHamil->catatan ?? '' }}</td>
                    <td>
                        <a href="#editformat5{{$ibuHamil->ibu_hamil_id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                        <a href="#deleteformat5{{$ibuHamil->ibu_hamil_id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Add New Data Modal -->
<!-- Add -->
<div class="modal fade" id="addnewformat5" tabindex="-1" role="dialog" aria-labelledby="addModal5" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal5"><b>Tambah Data Format 5 - SIP (Ibu Hamil)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-add-format5" method="POST" action="{{ route('sip5.store') }}">
                    @csrf
                    <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />

                    <div class="form-group">
                        <label for="nama_ibu_hamil">Nama Ibu Hamil</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu hamil" id="nama_ibu_hamil" name="nama_ibu_hamil" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur" id="umur" name="umur" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat_kelompok">Alamat/Kelompok</label>
                                <input type="text" class="form-control" placeholder="Masukkan alamat/kelompok" id="alamat_kelompok" name="alamat_kelompok" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                            @foreach($dasawismaList as $dasawisma)
                            <option value="{{ $dasawisma->dasawisma_id }}">{{ $dasawisma->nama_dasawisma }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
                        <input type="date" class="form-control" id="tanggal_pendaftaran" name="tanggal_pendaftaran" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur_kehamilan">Umur Kehamilan (minggu)</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur kehamilan" id="umur_kehamilan" name="umur_kehamilan" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hamil_ke">Hamil Ke-</label>
                                <input type="number" class="form-control" placeholder="Masukkan urutan kehamilan" id="hamil_ke" name="hamil_ke" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ukuran_lila">Ukuran LILA (cm)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila" name="ukuran_lila" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pmt_pemulihan">PMT Pemulihan</label>
                                <select class="form-control" id="pmt_pemulihan" name="pmt_pemulihan" required>
                                    <option value="">Pilih</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Penimbangan (TB/BB) per Bulan -->
                    <div class="form-group">
                        <label><strong>Hasil Penimbangan (BB) per Bulan (Opsional)</strong></label>
                        <div class="row">
                            @foreach(['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'] as $index => $bulan)
                            @php $bulanNumber = $index + 1; @endphp
                            <div class="col-md-2 mb-2">
                                <label for="penimbangan_{{ $bulanNumber }}">{{ $bulan }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" step="0.1" class="form-control form-control-sm"
                                            placeholder="TB" id="tb_{{ $bulanNumber }}" name="tb_{{ $bulanNumber }}" />
                                        <small class="text-muted">TB (cm)</small>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" step="0.1" class="form-control form-control-sm"
                                            placeholder="BB" id="bb_{{ $bulanNumber }}" name="bb_{{ $bulanNumber }}" />
                                        <small class="text-muted">BB (kg)</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tablet Tambah Darah (BKS) -->
                    <div class="form-group">
                        <label><strong>Tablet Tambah Darah (BKS)</strong></label>
                        <div class="row">
                            @foreach(['I', 'II', 'III'] as $jenis)
                            <div class="col-md-4">
                                <label for="tablet_{{ $jenis }}">Tablet {{ $jenis }}</label>
                                <input type="date" class="form-control" id="tablet_{{ $jenis }}" name="tablet_{{ $jenis }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Imunisasi -->
                    <div class="form-group">
                        <label><strong>Imunisasi</strong></label>
                        <div class="row">
                            @foreach(['I', 'II', 'III', 'IV', 'V'] as $jenis)
                            <div class="col-md-2">
                                <label for="imunisasi_{{ $jenis }}">Imunisasi {{ $jenis }}</label>
                                <input type="date" class="form-control" id="imunisasi_{{ $jenis }}" name="imunisasi_{{ $jenis }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Vitamin A -->
                    <div class="form-group">
                        <label for="vitamin_a">Vitamin A</label>
                        <input type="date" class="form-control" id="vitamin_a" name="vitamin_a" />
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" placeholder="Masukkan catatan (opsional)" id="catatan" name="catatan" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cancel
                </button>
                <button type="submit" form="form-add-format5" class="btn btn-success">
                    <i class="fa fa-check"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Set tanggal maksimal ke hari ini untuk semua input tanggal
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('#addnewformat5 input[type="date"]');

        dateInputs.forEach(function(input) {
            input.setAttribute('max', today);
        });

        // Debug modal issues
        console.log('Format 5 modal loaded');

        // Check if modal exists and is properly structured
        const modal = document.getElementById('addnewformat5');
        if (modal) {
            console.log('Modal exists:', modal);
            console.log('Modal HTML:', modal.outerHTML.substring(0, 200) + '...');
        }

        // Force modal to show when button is clicked with pure JavaScript
        const modalButton = document.querySelector('[href="#addnewformat5"]');
        if (modalButton) {
            modalButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Format 5 button clicked - using pure JS');

                // Remove any existing backdrop
                const existingBackdrops = document.querySelectorAll('.modal-backdrop');
                existingBackdrops.forEach(backdrop => backdrop.remove());

                // Show modal manually
                const modal = document.getElementById('addnewformat5');
                if (modal) {
                    modal.style.display = 'block';
                    modal.classList.add('show');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('modal-open');

                    // Add backdrop
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);

                    console.log('Modal should be visible now');
                } else {
                    console.error('Modal not found!');
                }
            });
        }

        // Close modal function
        function closeModal() {
            const modal = document.getElementById('addnewformat5');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');

                // Remove backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }

        // Add close event listeners
        const closeButtons = document.querySelectorAll('#addnewformat5 [data-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });

        // Close on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                closeModal();
            }
        });
    });
</script>

<style>
    /* Ensure modal appears above everything */
    #addnewformat5 {
        z-index: 1060 !important;
    }

    #addnewformat5 .modal-dialog {
        margin: 1.75rem auto;
        max-width: 1140px;
    }

    /* Ensure backdrop is below modal */
    .modal-backdrop {
        z-index: 1040 !important;
    }

    /* Force modal to be visible when show class is applied */
    #addnewformat5.show {
        display: block !important;
    }
</style>


@foreach($ibuHamilList as $ibuHamil)
<!-- Edit -->
<div class="modal fade" id="editformat5{{$ibuHamil->ibu_hamil_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Data Format 5 - SIP (Ibu Hamil)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('sip5.update', $ibuHamil->ibu_hamil_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ibu_hamil_id" value="{{ $ibuHamil->ibu_hamil_id }}" />
                    <input type="hidden" name="posyandu_id" value="{{ $ibuHamil->posyandu_id }}" />

                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama ibu hamil" id="nama_ibu" name="nama_ibu"
                            value="{{ $ibuHamil->nama_ibu ?? '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur" id="umur" name="umur"
                                    value="{{ $ibuHamil->umur ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat_kelompok">Alamat/Kelompok</label>
                                <input type="text" class="form-control" placeholder="Masukkan alamat/kelompok" id="alamat_kelompok" name="alamat_kelompok"
                                    value="{{ $ibuHamil->alamat_kelompok ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dasawisma_id">Dasawisma</label>
                        <select class="form-control" id="dasawisma_id" name="dasawisma_id" required>
                            <option value="">Pilih Dasawisma</option>
                            @if(isset($dasawismaList))
                            @foreach($dasawismaList as $dasawisma)
                            <option value="{{ $dasawisma->dasawisma_id }}" {{ ($ibuHamil->dasawisma_id ?? '') == $dasawisma->dasawisma_id ? 'selected' : '' }}>
                                {{ $dasawisma->nama_dasawisma }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
                        <input type="date" class="form-control" id="tanggal_pendaftaran" name="tanggal_pendaftaran"
                            value="{{ $ibuHamil->tanggal_pendaftaran ? $ibuHamil->tanggal_pendaftaran->format('Y-m-d') : '' }}" required />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="umur_kehamilan">Umur Kehamilan (minggu)</label>
                                <input type="number" class="form-control" placeholder="Masukkan umur kehamilan" id="umur_kehamilan" name="umur_kehamilan"
                                    value="{{ $ibuHamil->umur_kehamilan ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hamil_ke">Hamil Ke-</label>
                                <input type="number" class="form-control" placeholder="Masukkan urutan kehamilan" id="hamil_ke" name="hamil_ke"
                                    value="{{ $ibuHamil->hamil_ke ?? '' }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ukuran_lila">Ukuran LILA (cm)</label>
                                <input type="number" step="0.1" class="form-control" placeholder="Masukkan ukuran LILA" id="ukuran_lila" name="ukuran_lila"
                                    value="{{ $ibuHamil->ukuran_lila ?? '' }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pmt_pemulihan">PMT Pemulihan</label>
                                <select class="form-control" id="pmt_pemulihan" name="pmt_pemulihan" required>
                                    <option value="">Pilih</option>
                                    <option value="1" {{ ($ibuHamil->pmt_pemulihan ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ ($ibuHamil->pmt_pemulihan ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" placeholder="Masukkan catatan (opsional)" id="catatan" name="catatan" rows="3">{{ $ibuHamil->catatan ?? '' }}</textarea>
                    </div>

                    <!-- Hasil Penimbangan (TB/BB) per Bulan -->
                    <div class="form-group">
                        <label><strong>Hasil Penimbangan (BB) per Bulan</strong></label>
                        <div class="row">
                            @foreach(['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'] as $index => $bulan)
                            @php
                            $bulanNumber = $index + 1;
                            $dataTimbang = $ibuHamil->penimbanganIbuHamil->firstWhere('bulan', $bulanNumber);
                            @endphp
                            <div class="col-md-2 mb-2">
                                <label for="penimbangan_{{ $bulanNumber }}">{{ $bulan }}</label>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="number" step="0.1" class="form-control form-control-sm"
                                            placeholder="Berat Badan (kg)" id="bb_{{ $bulanNumber }}" name="bb_{{ $bulanNumber }}"
                                            value="{{ $dataTimbang ? $dataTimbang->berat_badan : '' }}" />
                                        <small class="text-muted">BB (kg)</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tablet Tambah Darah (BKS) -->
                    <div class="form-group">
                        <label><strong>Tablet Tambah Darah (BKS)</strong></label>
                        <div class="row">
                            @foreach(['I', 'II', 'III'] as $jenis)
                            @php
                            $tabletTambahDarah = $ibuHamil->tabletTambahDarah->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-4">
                                <label for="tablet_{{ $jenis }}">Tablet {{ $jenis }}</label>
                                <input type="date" class="form-control" id="tablet_{{ $jenis }}" name="tablet_{{ $jenis }}"
                                    value="{{ $tabletTambahDarah ? $tabletTambahDarah->tanggal_diberikan->format('Y-m-d') : '' }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Imunisasi -->
                    <div class="form-group">
                        <label><strong>Imunisasi</strong></label>
                        <div class="row">
                            @foreach(['I', 'II', 'III', 'IV', 'V'] as $jenis)
                            @php
                            $imunisasittIbuHamil = $ibuHamil->imunisasittIbuHamil->firstWhere('jenis', $jenis);
                            @endphp
                            <div class="col-md-2">
                                <label for="imunisasi_{{ $jenis }}">Imunisasi {{ $jenis }}</label>
                                <input type="date" class="form-control" id="imunisasi_{{ $jenis }}" name="imunisasi_{{ $jenis }}"
                                    value="{{ $imunisasittIbuHamil ? $imunisasittIbuHamil->tanggal_diberikan->format('Y-m-d') : '' }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Vitamin A -->
                    <div class="form-group">
                        <label for="vitamin_a">Vitamin A</label>
                        @php
                        $vitaminData = $ibuHamil->vitaminIbuHamil->first();
                        @endphp
                        <input type="date" class="form-control" id="vitamin_a" name="vitamin_a"
                            value="{{ $vitaminData ? $vitaminData->tanggal_pemberian->format('Y-m-d') : '' }}" />
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
<div class="modal fade" id="deleteformat5{{ $ibuHamil->ibu_hamil_id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
                <h4 class="modal-title "><span class="student_id">Delete Data Format 5 - SIP</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('sip5.delete', $ibuHamil->ibu_hamil_id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ibu_hamil_id" value="{{ $ibuHamil->ibu_hamil_id }}" />
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $ibuHamil->nama_ibu }}</h2>
                        <p>Umur: {{ $ibuHamil->umur }} tahun</p>
                        <p>Alamat/Kelompok: {{ $ibuHamil->alamat_kelompok }}</p>
                        <p>Hamil Ke-{{ $ibuHamil->hamil_ke }}</p>
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
    // Set tanggal maksimal ke hari ini untuk semua input tanggal edit di Format 5
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('#editformat5 input[type="date"], [name="tanggal_pendaftaran"], [name*="tablet_"], [name*="imunisasi_"], [name="vitamin_a"]');

        dateInputs.forEach(function(input) {
            input.setAttribute('max', today);
        });
    });
</script>
@endforeach