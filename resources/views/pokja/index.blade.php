@extends('layouts.master')

@section('css')
<style>
    /* Fix scroll issues for long tables */
    #wrapper {
        height: auto !important;
        min-height: 100vh !important;
        overflow: visible !important;
        overflow-y: auto !important;
    }
    
    html, body {
        overflow-x: auto !important;
        overflow-y: auto !important;
        height: auto !important;
        max-height: none !important;
        min-height: 100vh !important;
    }
    
    .content-page, .content, .container-fluid {
        overflow: visible !important;
        height: auto !important;
        max-height: none !important;
    }
    
    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 0.25rem 0.25rem 0 0;
    }
    
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    
    .pokja-dropdown .dropdown-item {
        padding: 8px 20px;
    }
    
    .pokja-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .pokja-dropdown .dropdown-item.active {
        background-color: #007bff;
        color: white;
    }
    
    .tab-content {
        background: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 20px;
    }
</style>
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Data Kelompok Kerja (Pokja)</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Pokja</a></li>
        <li class="breadcrumb-item active">{{ $currentPokja['name'] }}</li>
    </ol>
</div>
@endsection

@section('button')
<div class="d-flex align-items-center">
    <!-- Pokja Dropdown -->
    <div class="dropdown mr-3">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="pokjaDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-users"></i> {{ $currentPokja['name'] }}
        </button>
        <div class="dropdown-menu pokja-dropdown" aria-labelledby="pokjaDropdown">
            @foreach($pokjaStructure as $key => $pokja)
            <a class="dropdown-item {{ $key == $pokjaType ? 'active' : '' }}" href="{{ route('pokja.index', $key) }}">
                <i class="fa fa-group"></i> {{ $pokja['name'] }}
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('content')
@include('includes.flash')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fa fa-users text-primary"></i> 
                    {{ $currentPokja['name'] }} - Dokumentasi Kegiatan
                </h5>
            </div>
            
            <div class="card-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="pokjaTabs" role="tablist">
                    @foreach($tabs as $tabKey => $tabName)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                           id="{{ $tabKey }}-tab" 
                           data-toggle="tab" 
                           href="#{{ $tabKey }}" 
                           role="tab" 
                           aria-controls="{{ $tabKey }}" 
                           aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            <i class="fa fa-folder"></i> {{ $tabName }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                
                <!-- Tabs Content -->
                <div class="tab-content" id="pokjaTabsContent">
                    @foreach($tabs as $tabKey => $tabName)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="{{ $tabKey }}" 
                         role="tabpanel" 
                         aria-labelledby="{{ $tabKey }}-tab">
                        
                        <!-- Tab Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fa fa-list-alt text-success"></i> 
                                Data {{ $tabName }}
                            </h6>
                            <button type="button" class="btn btn-success btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#addModal" 
                                    onclick="setAddModalData('{{ $tabKey }}', '{{ $tabName }}')">
                                <i class="fa fa-plus"></i> Tambah Data
                            </button>
                        </div>
                        
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="25%">Nama Kegiatan</th>
                                        <th width="30%">Deskripsi</th>
                                        <th width="15%">Gambar</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tabsData[$tabKey] as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td>{{ Str::limit($item->deskripsi, 100) }}</td>
                                        <td>
                                            @if($item->file_gambar)
                                            <img src="{{ asset('storage/' . $item->file_gambar) }}" 
                                                 alt="Dokumentasi" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 80px; cursor: pointer;"
                                                 onclick="showImageModal('{{ asset('storage/' . $item->file_gambar) }}', '{{ $item->nama_kegiatan }}')">
                                            @else
                                            <span class="text-muted">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm mb-1" 
                                                    data-toggle="modal" 
                                                    data-target="#editModal" 
                                                    onclick="setEditModalData({{ json_encode($item) }})">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm mb-1" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal" 
                                                    onclick="setDeleteModalData({{ $item->pokja_id }}, '{{ $item->nama_kegiatan }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <i class="fa fa-info-circle"></i> Belum ada data untuk {{ $tabName }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // Fix wrapper height issues
    setTimeout(function() {
        $('#wrapper').css({
            'height': 'auto',
            'min-height': '100vh',
            'overflow': 'visible',
            'overflow-y': 'auto'
        });
        
        $('.content-page, .content, .container-fluid').css({
            'height': 'auto',
            'overflow': 'visible'
        });
    }, 1000);
});

// Set data for add modal
function setAddModalData(namaPokja, judulPokja) {
    document.getElementById('add_nama_pokja').value = namaPokja;
    document.getElementById('add_judul_pokja').value = judulPokja;
}

// Set data for edit modal
function setEditModalData(data) {
    document.getElementById('edit_pokja_id').value = data.pokja_id;
    document.getElementById('edit_judul_pokja').value = data.judul_pokja;
    document.getElementById('edit_tanggal').value = data.tanggal;
    document.getElementById('edit_nama_kegiatan').value = data.nama_kegiatan;
    document.getElementById('edit_deskripsi').value = data.deskripsi;
    
    // Update form action
    document.getElementById('editForm').action = "{{ route('pokja.update', '') }}/" + data.pokja_id;
}

// Set data for delete modal
function setDeleteModalData(id, namaKegiatan) {
    document.getElementById('delete_pokja_id').value = id;
    document.getElementById('delete_nama_kegiatan').textContent = namaKegiatan;
    
    // Update form action
    document.getElementById('deleteForm').action = "{{ route('pokja.destroy', '') }}/" + id;
}

// Show image modal
function showImageModal(imageSrc, title) {
    $('#imageModal').modal('show');
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImageTitle').textContent = title;
}
</script>
@endsection

<!-- Include Modals -->
@include('pokja.modals.add')
@include('pokja.modals.edit')
@include('pokja.modals.delete')
@include('pokja.modals.image')
