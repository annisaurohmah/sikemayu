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

                        <!-- Hasil Penimbangan (BB dan Umur Kehamilan) per Bulan -->
                        <div class="form-group">
                            <label><strong>Hasil Penimbangan (BB dan Umur Kehamilan) per Bulan (Opsional)</strong></label>
                            <div class="row">
                                @foreach(['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'] as $index => $bulan)
                                @php $bulanNumber = $index + 1; @endphp
                                <div class="col-md-2 mb-2">
                                    <label for="penimbangan_{{ $bulanNumber }}">{{ $bulan }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="number" step="0.1" class="form-control form-control-sm" 
                                                   placeholder="BB" id="bb_{{ $bulanNumber }}" name="bb_{{ $bulanNumber }}" />
                                            <small class="text-muted">BB (kg)</small>
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control form-control-sm" 
                                                   placeholder="UK" id="uk_{{ $bulanNumber }}" name="uk_{{ $bulanNumber }}" />
                                            <small class="text-muted">UK (minggu)</small>
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