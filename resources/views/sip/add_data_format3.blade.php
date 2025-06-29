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

                        <div class="form-group">
                            <label><strong>Pilih Jenis Input Balita</strong></label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="input_database_balita" name="input_type" value="database" checked>
                                    <label class="form-check-label" for="input_database_balita">Pilih dari Database</label>
                                </div>
                                <div class="form-check form-check-inline ml-3">
                                    <input type="radio" class="form-check-input" id="input_manual_balita" name="input_type" value="manual">
                                    <label class="form-check-label" for="input_manual_balita">Input Manual</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input dari Database -->
                        <div id="database_input_balita" class="form-group">
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

                        <!-- Input Manual -->
                        <div id="manual_input_balita" class="form-group" style="display: none; border: 2px dashed #28a745; padding: 15px; border-radius: 5px; background-color: #f8f9fa;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_balita_manual">Nama Balita <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Masukkan nama balita" id="nama_balita_manual" name="nama_balita_manual" />
                                        <small class="form-text text-muted">Input nama balita secara manual</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir_manual_balita">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tgl_lahir_manual_balita" name="tgl_lahir_manual" max="{{ date('Y-m-d') }}" />
                                        <small class="form-text text-muted">Tanggal lahir balita (1-5 tahun yang lalu)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field untuk nama balita yang akan dikirim -->
                        <input type="hidden" id="nama_balita" name="nama_balita" />
                        <input type="hidden" id="tgl_lahir_balita" name="tgl_lahir" />

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
$(document).ready(function() {
    // Initialize Select2 for database input
    $('#nama_balita_db').select2({
        placeholder: 'Pilih atau ketik nama balita...',
        allowClear: true
    });

    // Toggle input type untuk balita
    $('input[name="input_type"]').on('change', function() {
        const inputType = $(this).val();
        
        if (inputType === 'database') {
            $('#database_input_balita').show();
            $('#manual_input_balita').hide();
            
            // Clear manual inputs and remove required
            $('#nama_balita_manual').val('').removeAttr('required');
            $('#tgl_lahir_manual_balita').val('').removeAttr('required');
            
            // Set database input as required
            $('#nama_balita_db').attr('required', 'required');
            
            // Clear hidden fields
            $('#nama_balita').val('');
            $('#tgl_lahir_balita').val('');
        } else {
            $('#database_input_balita').hide();
            $('#manual_input_balita').show();
            
            // Clear database inputs and remove required
            $('#nama_balita_db').val(null).trigger('change').removeAttr('required');
            
            // Set manual inputs as required
            $('#nama_balita_manual').attr('required', 'required');
            $('#tgl_lahir_manual_balita').attr('required', 'required');
            
            // Clear auto-filled parent names
            $('#nama_ayah').val('');
            $('#nama_ibu').val('');
            
            // Clear hidden fields
            $('#nama_balita').val('');
            $('#tgl_lahir_balita').val('');
        }
    });

    // Auto-fill data ketika balita dari database dipilih
    $('#nama_balita_db').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const namaOrangtua = selectedOption.data('orangtua');
        const tglLahir = selectedOption.data('tgl');
        
        // Set hidden fields
        $('#nama_balita').val($(this).val());
        
        // Handle tanggal lahir
        if (tglLahir) {
            // Format tanggal jika perlu
            let formattedDate = tglLahir;
            if (typeof tglLahir === 'object') {
                // Jika object date, format ke YYYY-MM-DD
                formattedDate = tglLahir.toISOString().split('T')[0];
            } else if (typeof tglLahir === 'string') {
                // Jika string, pastikan formatnya benar
                const dateObj = new Date(tglLahir);
                if (!isNaN(dateObj.getTime())) {
                    formattedDate = dateObj.toISOString().split('T')[0];
                }
            }
            $('#tgl_lahir_balita').val(formattedDate);
        }
        
        if (namaOrangtua) {
            // Split nama orangtua jika ada format "Nama Ayah / Nama Ibu"
            const orangtuaParts = namaOrangtua.split('/');
            if (orangtuaParts.length >= 2) {
                $('#nama_ayah').val(orangtuaParts[0].trim());
                $('#nama_ibu').val(orangtuaParts[1].trim());
            } else {
                // Jika hanya satu nama, masukkan ke nama ayah dan kosongkan nama ibu
                $('#nama_ayah').val(namaOrangtua);
                $('#nama_ibu').val('');
            }
        }
    });
    
    // Handle manual input untuk balita - real time update
    $('#nama_balita_manual').on('input', function() {
        $('#nama_balita').val($(this).val());
        console.log('Manual nama balita updated:', $(this).val());
    });
    
    $('#tgl_lahir_manual_balita').on('change', function() {
        $('#tgl_lahir_balita').val($(this).val());
        console.log('Manual tgl lahir balita updated:', $(this).val());
    });
    
    // Form validation before submit
    $('form').on('submit', function(e) {
        const inputType = $('input[name="input_type"]:checked').val();
        let isValid = true;
        let errorMessage = '';
        
        console.log('Form submit - Input type:', inputType);
        console.log('Hidden nama_balita value:', $('#nama_balita').val());
        console.log('Hidden tgl_lahir_balita value:', $('#tgl_lahir_balita').val());
        
        if (inputType === 'database') {
            if (!$('#nama_balita_db').val()) {
                errorMessage = 'Silakan pilih balita dari database!';
                isValid = false;
            }
        } else {
            const namaBalita = $('#nama_balita_manual').val().trim();
            const tglLahir = $('#tgl_lahir_manual_balita').val();
            
            if (!namaBalita || !tglLahir) {
                errorMessage = 'Silakan lengkapi nama balita dan tanggal lahir!';
                isValid = false;
            } else {
                // Validate date (must be within 1-5 years old)
                const tglLahirDate = new Date(tglLahir);
                const today = new Date();
                const yearsDiff = today.getFullYear() - tglLahirDate.getFullYear();
                const monthsDiff = (today.getFullYear() - tglLahirDate.getFullYear()) * 12 + (today.getMonth() - tglLahirDate.getMonth());
                
                if (tglLahirDate > today) {
                    errorMessage = 'Tanggal lahir tidak boleh di masa depan!';
                    isValid = false;
                } else if (monthsDiff <= 12) {
                    errorMessage = 'Umur balita harus lebih dari 12 bulan (1 tahun)!';
                    isValid = false;
                } else if (yearsDiff > 5) {
                    errorMessage = 'Umur balita tidak boleh lebih dari 5 tahun!';
                    isValid = false;
                }
            }
            
            // Update hidden fields one more time before submit
            $('#nama_balita').val(namaBalita);
            $('#tgl_lahir_balita').val(tglLahir);
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
        
        return true;
    });
    
    // Debug function to show current form state
    function debugFormState() {
        console.log('=== FORM DEBUG STATE (Format 3) ===');
        console.log('Input type checked:', $('input[name="input_type"]:checked').val());
        console.log('Database nama value:', $('#nama_balita_db').val());
        console.log('Manual nama value:', $('#nama_balita_manual').val());
        console.log('Manual tgl lahir value:', $('#tgl_lahir_manual_balita').val());
        console.log('Hidden nama_balita value:', $('#nama_balita').val());
        console.log('Hidden tgl_lahir_balita value:', $('#tgl_lahir_balita').val());
        console.log('==================================');
    }
    
    // Add debug button for testing (remove in production)
    if (window.location.search.includes('debug=1')) {
        $('form').append('<button type="button" class="btn btn-info" onclick="debugFormState()">Debug Form</button>');
    }
    
    // Set tahun default ke tahun sekarang jika ada input tahun
    const tahunInput = document.getElementById('tahun');
    if (tahunInput) {
        tahunInput.value = new Date().getFullYear();
    }
    
    // Set max date for manual input (today)
    const today = new Date().toISOString().split('T')[0];
    $('#tgl_lahir_manual_balita').attr('max', today);
    
    // Set min date for manual input (5 years ago)
    const fiveYearsAgo = new Date();
    fiveYearsAgo.setFullYear(fiveYearsAgo.getFullYear() - 5);
    const minDate = fiveYearsAgo.toISOString().split('T')[0];
    $('#tgl_lahir_manual_balita').attr('min', minDate);
});
</script>