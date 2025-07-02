<!-- Add -->
<div class="modal fade" id="addnewformat3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Log on to codeastro.com for more projects! -->

            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 3 - SIP (Balita)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip3.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />

                        <!-- Input Mode Selection with Tabs -->
                        <div class="form-group">
                            <label><strong>Pilih Jenis Input Balita</strong></label>
                            <ul class="nav nav-tabs mt-2" id="inputTab-balita" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="db-tab-balita" data-toggle="tab" href="#database_input_balita" role="tab" aria-controls="database_input_balita" aria-selected="true">
                                        <i class="mdi mdi-database mr-1"></i> Dari Database
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="manual-tab-balita" data-toggle="tab" href="#manual_input_balita" role="tab" aria-controls="manual_input_balita" aria-selected="false">
                                        <i class="mdi mdi-pencil mr-1"></i> Input Manual
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content" id="inputTabContent-balita">
                            <!-- Input dari Database -->
                            <div class="tab-pane fade show active" id="database_input_balita" role="tabpanel" aria-labelledby="db-tab-balita">
                                <div class="form-group mt-3">
                                    <label for="nama_balita_db">Nama Balita (dari Database)</label>
                                    <select class="form-control select2" id="nama_balita_db" name="nama_balita_db">
                                        <option value="">Pilih Balita</option>
                                        @if(isset($balitaList_master))
                                        @foreach($balitaList_master as $balita)
                                        <option value="{{ $balita->nama_lengkap }}" data-nik="{{ $balita->nik }}" data-tgl="{{ $balita->tanggal_lahir }}" data-orangtua="{{ $balita->nama_lengkap_ortu }}">
                                            {{ $balita->nama_lengkap }} - {{ $balita->nama_lengkap_ortu }} ({{ $balita->tanggal_lahir ? $balita->tanggal_lahir->format('d-m-Y') : '' }})
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">Pilih dari data balita yang sudah terdaftar atau ketik untuk mencari</small>
                                </div>
                            </div>

                            <!-- Input Manual -->
                            <div class="tab-pane fade" id="manual_input_balita" role="tabpanel" aria-labelledby="manual-tab-balita">
                                <div class="form-group mt-3" style="border: 2px dashed #28a745; padding: 15px; border-radius: 5px; background-color: #f8f9fa;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_balita_manual">Nama Balita <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Masukkan nama balita" id="nama_balita_manual" name="nama_balita_manual" />
                                                <small class="form-text text-muted">Input nama balita secara manual</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                                <label for="tgl_lahir_manual_balita">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir_manual_balita" name="tgl_lahir_manual" max="{{ date('Y-m-d') }}" />
                                <small class="form-text text-muted">Tanggal lahir balita (1-5 tahun yang lalu) - opsional</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field untuk nama balita yang akan dikirim -->
                        <input type="hidden" id="nama_balita" name="nama_balita" />
                        <input type="hidden" id="tgl_lahir" name="tgl_lahir" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bbl_kg">Berat Badan Lahir (kg)</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" id="bbl_kg" name="bbl_kg" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dasawisma_id">Dasawisma</label>
                                    <select class="form-control" id="dasawisma_id" name="dasawisma_id">
                                        <option value="">Pilih Dasawisma</option>
                                        @if(isset($dasawismaList))
                                        @foreach($dasawismaList as $dasawisma)
                                        <option value="{{ $dasawisma->dasawisma_id }}">{{ $dasawisma->nama_dasawisma }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_ayah">Nama Ayah</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ayah" id="nama_ayah" name="nama_ayah" />
                        </div>

                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" />
                        </div>
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
    </div>
</div>
</div>

<script>
    // Define functions outside of document.ready so they can be called globally
    function setupTabToggleBalita() {
        // Handle tab switching for balita
        $('#inputTab-balita a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const targetTab = $(e.target).attr('href');
            console.log('Balita tab switched to:', targetTab);

            if (targetTab === '#database_input_balita') {
                // Database mode
                // Clear manual inputs and remove required
                $('#nama_balita_manual').val('').removeAttr('required');
                $('#tgl_lahir_manual_balita').val('').removeAttr('required');

                // Set database input as required
                $('#nama_balita_db').attr('required', 'required');            // Clear hidden fields
            $('#nama_balita').val('');
            $('#tgl_lahir').val('');
            
            console.log('Switched to database mode for balita');
        } else if (targetTab === '#manual_input_balita') {
            // Manual mode
            // Clear database inputs and remove required
            $('#nama_balita_db').val(null).trigger('change').removeAttr('required');                // Set manual inputs as required (only name)
                $('#nama_balita_manual').attr('required', 'required');
                // Note: Date is optional
            
            // Clear auto-filled parent names
            $('#nama_ayah').val('');
            $('#nama_ibu').val('');
            
            // Clear hidden fields
            $('#nama_balita').val('');
            $('#tgl_lahir').val('');

                console.log('Switched to manual mode for balita');
            }
        });
    }

    // Auto-fill data ketika balita dari database dipilih
    function setupDatabaseAutoFillBalita() {
        $('#nama_balita_db').off('change').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const namaOrangtua = selectedOption.data('orangtua');
            const tglLahir = selectedOption.data('tgl');

            // Set hidden fields
            $('#nama_balita').val($(this).val());

            // Handle tanggal lahir
            if (tglLahir) {
                let formattedDate = tglLahir;
                if (typeof tglLahir === 'object') {
                    formattedDate = tglLahir.toISOString().split('T')[0];
                } else if (typeof tglLahir === 'string') {
                    const dateObj = new Date(tglLahir);
                    if (!isNaN(dateObj.getTime())) {
                        formattedDate = dateObj.toISOString().split('T')[0];
                    }            }
            $('#tgl_lahir').val(formattedDate);
        }
        
        if (namaOrangtua) {
                const orangtuaParts = namaOrangtua.split('/');
                if (orangtuaParts.length >= 2) {
                    $('#nama_ayah').val(orangtuaParts[0].trim());
                    $('#nama_ibu').val(orangtuaParts[1].trim());
                } else {
                    $('#nama_ayah').val(namaOrangtua);
                    $('#nama_ibu').val('');
                }
            }
        });
    }

    // Handle manual input - real time update
    function setupManualInputBalita() {
        $('#nama_balita_manual').off('input').on('input', function() {
            $('#nama_balita').val($(this).val());
            console.log('Manual nama balita updated:', $(this).val());
        });

    $('#tgl_lahir_manual_balita').off('change').on('change', function() {
        $('#tgl_lahir').val($(this).val());
        console.log('Manual tgl lahir balita updated:', $(this).val());
    });
    }

    // Form validation before submit
    function setupFormValidationBalita() {
        $('#addnewformat3 form').off('submit').on('submit', function(e) {
            const activeTab = $('#inputTab-balita .nav-link.active').attr('href');
            let isValid = true;
            let errorMessage = '';

            console.log('Form submitting with active tab:', activeTab);

            if (activeTab === '#database_input_balita') {
                if (!$('#nama_balita_db').val()) {
                    errorMessage = 'Silakan pilih balita dari database!';
                    isValid = false;
                }
            } else {
                const namaBalita = $('#nama_balita_manual').val().trim();
                const tglLahir = $('#tgl_lahir_manual_balita').val();

                console.log('Manual input values:', {
                    namaBalita,
                    tglLahir
                });

                if (!namaBalita) {
                    errorMessage = 'Silakan lengkapi nama balita!';
                    isValid = false;
                } else if (tglLahir) {
                    // Only validate date if it's provided (optional)
                    const tglLahirDate = new Date(tglLahir);
                    const today = new Date();
                    const monthsDiff = (today.getFullYear() - tglLahirDate.getFullYear()) * 12 + (today.getMonth() - tglLahirDate.getMonth());

                    if (tglLahirDate > today) {
                        errorMessage = 'Tanggal lahir tidak boleh di masa depan!';
                        isValid = false;
                    } else if (monthsDiff < 12) {
                        errorMessage = 'Tanggal lahir harus lebih dari 12 bulan yang lalu untuk kategori balita!';
                        isValid = false;
                    } else if (monthsDiff > 60) {
                        errorMessage = 'Tanggal lahir harus dalam rentang 1-5 tahun dari sekarang untuk kategori balita!';
                        isValid = false;
                    }
                }

                // Update hidden fields one more time before submit
                $('#nama_balita').val(namaBalita);
                if (tglLahir) {
                    $('#tgl_lahir').val(tglLahir);
                }
        }
        
        if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
                return false;
            }

            // Final check - make sure hidden fields have values
            if (!$('#nama_balita').val()) {
                e.preventDefault();
                alert('Error: Nama balita tidak terdeteksi. Silakan coba lagi.');
                return false;
            }

            console.log('Form validation passed, submitting...');
            return true;
        });
    }

    // Set max and min date for manual input
    function setupDateLimitsBalita() {
        // Untuk balita (1-5 tahun): max = 1 tahun yang lalu, min = 5 tahun yang lalu
        const oneYearAgo = new Date();
        oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
        const maxDate = oneYearAgo.toISOString().split('T')[0];
        $('#tgl_lahir_manual_balita').attr('max', maxDate);
        
        const fiveYearsAgo = new Date();
        fiveYearsAgo.setFullYear(fiveYearsAgo.getFullYear() - 5);
        const minDate = fiveYearsAgo.toISOString().split('T')[0];
        $('#tgl_lahir_manual_balita').attr('min', minDate);
    }

    // Initialize when document is ready
    $(document).ready(function() {
        console.log('Format 3 Add Modal Script Loaded');

        // Initialize Select2 for database input
        $('#nama_balita_db').select2({
            placeholder: 'Pilih atau ketik nama balita...',
            allowClear: true
        });

        // Initialize all functions when document is ready
        setupTabToggleBalita();
        setupDatabaseAutoFillBalita();
        setupManualInputBalita();
        setupFormValidationBalita();
        setupDateLimitsBalita();

        console.log('All Format 3 functions initialized');
    });

    // Initialize modal event for when modal is shown
    $('#addnewformat3').on('shown.bs.modal', function() {
        console.log('Format 3 modal shown, re-initializing...');
        if (typeof initFormat3ManualInput === 'function') {
            initFormat3ManualInput();
        }
    });

    // Global function that can be called from parent page
    function initFormat3ManualInput() {
        console.log('Global initFormat3ManualInput called');

        // Re-initialize all functions
        setupTabToggleBalita();
        setupDatabaseAutoFillBalita();
        setupManualInputBalita();
        setupFormValidationBalita();
        setupDateLimitsBalita();

        console.log('Format 3 manual input re-initialized');
    }
</script>