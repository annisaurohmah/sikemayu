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
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="input_database" name="input_type" value="database" checked onchange="toggleInputType()">
                                    <label class="form-check-label" for="input_database">Pilih dari Database</label>
                                </div>
                                <div class="form-check form-check-inline ml-3">
                                    <input type="radio" class="form-check-input" id="input_manual" name="input_type" value="manual" onchange="toggleInputType()">
                                    <label class="form-check-label" for="input_manual">Input Manual</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input dari Database -->
                        <div id="database_input" class="form-group">
                            <label for="nama_bayi_db">Nama Bayi (dari Database)</label>
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

                        <!-- Input Manual -->
                        <div id="manual_input" class="form-group" style="display: none; border: 2px dashed #007bff; padding: 15px; border-radius: 5px; background-color: #f8f9fa;">
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

                        <!-- Hidden field untuk nama bayi yang akan dikirim -->
                        <input type="hidden" id="nama_bayi" name="nama_bayi" />
                        <input type="hidden" id="tgl_lahir" name="tgl_lahir" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bbl_kg">Berat Badan Lahir (kg)</label>
                                    <input type="number" step="0.1" class="form-control" placeholder="Masukkan berat badan lahir" id="bbl_kg" name="bbl_kg" required />
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_ayah">Nama Ayah</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ayah" id="nama_ayah" name="nama_ayah" required />
                        </div>

                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama ibu" id="nama_ibu" name="nama_ibu" required />
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
function setupInputToggle() {
    $('input[name="input_type"]').off('change').on('change', function() {
        const inputType = $(this).val();
        console.log('Input type changed to:', inputType);
        
        if (inputType === 'database') {
            $('#database_input').show();
            $('#manual_input').hide();
            
            // Clear manual inputs and remove required
            $('#nama_bayi_manual').val('').removeAttr('required');
            $('#tgl_lahir_manual').val('').removeAttr('required');
            
            // Set database input as required
            $('#nama_bayi_db').attr('required', 'required');
            
            // Clear hidden fields
            $('#nama_bayi').val('');
            $('#tgl_lahir').val('');
        } else {
            $('#database_input').hide();
            $('#manual_input').show();
            console.log('Manual input should be visible now');
            
            // Clear database inputs and remove required
            $('#nama_bayi_db').val('').removeAttr('required');
                
                // Set manual inputs as required
                $('#nama_bayi_manual').attr('required', 'required');
                $('#tgl_lahir_manual').attr('required', 'required');
                
                // Clear auto-filled parent names
                $('#nama_ayah').val('');
                $('#nama_ibu').val('');
                
                // Clear hidden fields
                $('#nama_bayi').val('');
                $('#tgl_lahir').val('');
            }
            
            // Debug visibility
            console.log('Database input visible:', $('#database_input').is(':visible'));
            console.log('Manual input visible:', $('#manual_input').is(':visible'));
        });
    }

    // Auto-fill data ketika bayi dari database dipilih
    function setupDatabaseAutoFill() {
        $('#nama_bayi_db').off('change').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const namaOrangtua = selectedOption.data('orangtua');
            const tglLahir = selectedOption.data('tgl');
            
            // Set hidden fields
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
            const inputType = $('input[name="input_type"]:checked').val();
            let isValid = true;
            let errorMessage = '';
            
            console.log('Form submitting with input type:', inputType);
            
            if (inputType === 'database') {
                if (!$('#nama_bayi_db').val()) {
                    errorMessage = 'Silakan pilih bayi dari database!';
                    isValid = false;
                }
            } else {
                const namaBayi = $('#nama_bayi_manual').val().trim();
                const tglLahir = $('#tgl_lahir_manual').val();
                
                console.log('Manual input values:', { namaBayi, tglLahir });
                
                if (!namaBayi || !tglLahir) {
                    errorMessage = 'Silakan lengkapi nama bayi dan tanggal lahir!';
                    isValid = false;
                } else {
                    // Validate date (must be within 0-12 months old)
                    const tglLahirDate = new Date(tglLahir);
                    const today = new Date();
                    const monthsDiff = (today.getFullYear() - tglLahirDate.getFullYear()) * 12 + (today.getMonth() - tglLahirDate.getMonth());
                    
                    if (tglLahirDate > today) {
                        errorMessage = 'Tanggal lahir tidak boleh di masa depan!';
                        isValid = false;
                    } else if (monthsDiff > 12) {
                        errorMessage = 'Tanggal lahir harus dalam rentang 0-12 bulan dari sekarang untuk kategori bayi!';
                        isValid = false;
                    }
                }
                
                // Update hidden fields one more time before submit
                $('#nama_bayi').val(namaBayi);
                $('#tgl_lahir').val(tglLahir);
            }
            
            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
                return false;
            }
            
            // Final check - make sure hidden fields have values
            if (!$('#nama_bayi').val()) {
                e.preventDefault();
                alert('Error: Nama bayi tidak terdeteksi. Silakan coba lagi.');
                return false;
            }
            
            console.log('Form validation passed, submitting...');
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
    
    // Initialize all functions when document is ready
    setupInputToggle();
    setupDatabaseAutoFill();
    setupManualInput();
    setupFormValidation();
    setupDateLimits();
    
    // Force trigger change event to set initial state
    $('input[name="input_type"]:checked').trigger('change');
    
    console.log('All Format 2 functions initialized');
});

// Global function that can be called from parent page
function initFormat2ManualInput() {
    console.log('Global initFormat2ManualInput called');
    
    // Re-initialize all functions
    setupInputToggle();
    setupDatabaseAutoFill();
    setupManualInput();
    setupFormValidation();
    setupDateLimits();
    
    // Force trigger change event to set initial state
    $('input[name="input_type"]:checked').trigger('change');
    
    console.log('Format 2 manual input re-initialized');
}
</script>