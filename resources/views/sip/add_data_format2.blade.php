<!-- Add -->
<div class="modal fade" id="addnewformat2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Tambah Data Format 2 - SIP (Bayi)</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('sip2.store') }}">
                        @csrf
                        <input type="hidden" name="posyandu_id" value="{{ $posyandu->posyandu_id ?? '' }}" />

                        <div class="form-group">
                            <label><strong>Pilih Jenis Input Bayi</strong></label>
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs mt-2" id="inputTypeTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="database-tab" data-toggle="tab" href="#database_input" role="tab" aria-controls="database_input" aria-selected="true">
                                        <i class="mdi mdi-database mr-1"></i>Dari Database
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual_input" role="tab" aria-controls="manual_input" aria-selected="false">
                                        <i class="mdi mdi-keyboard mr-1"></i>Input Manual
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3" id="inputTypeTabContent">
                                <!-- Input dari Database -->
                                <div class="tab-pane fade show active" id="database_input" role="tabpanel" aria-labelledby="database-tab">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="mdi mdi-database mr-2"></i>Pilih Bayi dari Database</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="nama_bayi_db">Nama Bayi</label>
                                                <select class="form-control select2" id="nama_bayi_db" name="nama_bayi_db">
                                                    <option value="">Pilih Bayi</option>
                                                    @if(isset($bayiList_master))
                                                    @foreach($bayiList_master as $bayi)
                                                    <option value="{{ $bayi->nama_lengkap }}" data-nik="{{ $bayi->nik }}" data-tgl="{{ $bayi->tanggal_lahir }}" data-orangtua="{{ $bayi->nama_lengkap_ortu }}">
                                                        {{ $bayi->nama_lengkap }} - {{ $bayi->nama_lengkap_ortu }} ({{ $bayi->tanggal_lahir ? $bayi->tanggal_lahir->format('d-m-Y') : '' }})
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <small class="form-text text-muted">Pilih dari data bayi yang sudah terdaftar atau ketik untuk mencari</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Manual -->
                                <div class="tab-pane fade" id="manual_input" role="tabpanel" aria-labelledby="manual-tab">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="mdi mdi-keyboard mr-2"></i>Input Data Bayi Manual</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nama_bayi_manual">Nama Bayi <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Masukkan nama bayi" id="nama_bayi_manual" name="nama_bayi_manual" />
                                                        <small class="form-text text-muted">Input nama bayi secara manual</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tgl_lahir_manual">Tanggal Lahir <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="tgl_lahir_manual" name="tgl_lahir_manual" max="{{ date('Y-m-d') }}" />
                                                        <small class="form-text text-muted">Tanggal lahir bayi (maksimal 12 bulan yang lalu)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field untuk nama bayi yang akan dikirim -->
                        <input type="hidden" id="nama_bayi" name="nama_bayi" />
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
    function setupTabToggle() {
        // Handle tab switching between database and manual input
        $('#inputTypeTab a[data-toggle="tab"]').off('shown.bs.tab').on('shown.bs.tab', function(e) {
            const target = $(e.target).attr("href"); // activated tab
            console.log('Tab switched to:', target);

            if (target === '#database_input') {
                // Database tab active
                $('#nama_bayi_db').attr('required', 'required');
                $('#nama_bayi_manual').removeAttr('required');
                $('#tgl_lahir_manual').removeAttr('required');

                // Clear manual inputs
                $('#nama_bayi_manual').val('');
                $('#tgl_lahir_manual').val('');
                $('#nama_ayah').val('');
                $('#nama_ibu').val('');

                // Clear hidden fields
                $('#nama_bayi').val('');
                $('#tgl_lahir').val('');

                console.log('Database input mode activated');
            } else if (target === '#manual_input') {
                // Manual tab active
                $('#nama_bayi_db').removeAttr('required');
                $('#nama_bayi_manual').attr('required', 'required');
                // Note: Other fields are optional

                // Clear database inputs
                $('#nama_bayi_db').val('').trigger('change');

                // Clear hidden fields
                $('#nama_bayi').val('');
                $('#tgl_lahir').val('');

                console.log('Manual input mode activated');
            }
        });
    }

    // Auto-fill data ketika bayi dari database dipilih
    function setupDatabaseAutoFill() {
        $('#nama_bayi_db').off('change').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const namaOrangtua = selectedOption.data('orangtua');
            const tglLahir = selectedOption.data('tgl');

            console.log('Database selection changed:', {
                nama: $(this).val(),
                tglLahir: tglLahir,
                namaOrangtua: namaOrangtua
            });

            // Set hidden field nama_bayi
            $('#nama_bayi').val($(this).val());

            // Handle tanggal lahir
            if (tglLahir) {
                let formattedDate = tglLahir;
                if (typeof tglLahir === 'object') {
                    formattedDate = tglLahir.toISOString().split('T')[0];
                } else if (typeof tglLahir === 'string') {
                    const dateObj = new Date(tglLahir);
                    if (!isNaN(dateObj.getTime())) {
                        formattedDate = dateObj.toISOString().split('T')[0];
                    }
                }
                $('#tgl_lahir').val(formattedDate);
                console.log('Set tgl_lahir to:', formattedDate);
            }

            // Handle nama orang tua
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
    function setupManualInput() {
        $('#nama_bayi_manual').off('input').on('input', function() {
            $('#nama_bayi').val($(this).val());
            console.log('Manual nama updated:', $(this).val());
        });

        $('#tgl_lahir_manual').off('change').on('change', function() {
            $('#tgl_lahir').val($(this).val());
            console.log('Manual tgl lahir updated:', $(this).val());
        });
    }

    // Form validation before submit
    function setupFormValidation() {
        $('#addnewformat2 form').off('submit').on('submit', function(e) {
            console.log('Form is submitting...');
            
            // Simplified validation - just check if we have at least a name
            const namaBayiDB = $('#nama_bayi_db').val();
            const namaBayiManual = $('#nama_bayi_manual').val();
            
            if (!namaBayiDB && !namaBayiManual) {
                e.preventDefault();
                alert('Silakan isi nama bayi!');
                return false;
            }
            
            // Set hidden fields
            if (namaBayiDB) {
                $('#nama_bayi').val(namaBayiDB);
            } else if (namaBayiManual) {
                $('#nama_bayi').val(namaBayiManual);
            }
            
            console.log('Form validation passed, submitting with nama_bayi:', $('#nama_bayi').val());
            return true;
        });
    }

    // Set max and min date for manual input
    function setupDateLimits() {
        const today = new Date().toISOString().split('T')[0];
        $('#tgl_lahir_manual').attr('max', today);

        const twelveMonthsAgo = new Date();
        twelveMonthsAgo.setMonth(twelveMonthsAgo.getMonth() - 12);
        const minDate = twelveMonthsAgo.toISOString().split('T')[0];
        $('#tgl_lahir_manual').attr('min', minDate);
    }

    // Initialize when document is ready
    $(document).ready(function() {
        console.log('Format 2 Add Modal Script Loaded');

        // Initialize when modal is shown
        $('#addnewformat2').on('shown.bs.modal', function() {
            console.log('Format 2 modal shown, re-initializing...');

            // Re-initialize all functions
            setupTabToggle();
            setupDatabaseAutoFill();
            setupManualInput();
            setupFormValidation();
            setupDateLimits();

            // Set default active tab to database
            $('#database-tab').tab('show');

            console.log('Format 2 modal functions initialized');
        });

        // Initialize all functions when document is ready
        setupTabToggle();
        setupDatabaseAutoFill();
        setupManualInput();
        setupFormValidation();
        setupDateLimits();

        // Set default active tab to database
        $('#database-tab').tab('show');

        console.log('All Format 2 functions initialized');
    });

    // Global function that can be called from parent page
    function initFormat2ManualInput() {
        console.log('Global initFormat2ManualInput called');

        // Re-initialize all functions
        setupTabToggle();
        setupDatabaseAutoFill();
        setupManualInput();
        setupFormValidation();
        setupDateLimits();

        // Set default active tab to database
        $('#database-tab').tab('show');

        console.log('Format 2 manual input re-initialized');
    }
</script>