@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Data Penduduk</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Master Data</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Data Penduduk</a></li>

    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Tambah Data Penduduk</a>
@endsection

@section('content')
@include('includes.flash')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Log on to codeastro.com for more projects! -->
                    <table id="penduduk-table" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <!-- Table structure will be built by JavaScript -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Log on to codeastro.com for more projects! -->
</div>
</div> <!-- end col -->
</div> <!-- end row -->




@endsection


@section('script')
<!-- Responsive-table-->
<script>
$(document).ready(function() {
    // Wait a bit to ensure any conflicting scripts finish first
    setTimeout(function() {
        initPendudukTable();
    }, 100);
});

function initPendudukTable() {
    // Check if DataTable already exists and destroy it first
    if ($.fn.DataTable.isDataTable('#penduduk-table')) {
        $('#penduduk-table').DataTable().destroy();
        $('#penduduk-table').empty(); // Clear table content
    }
    
    // Clear any existing table structure
    $('#penduduk-table').html(`
        <thead class="thead-dark">
            <tr>
                <th data-priority="1">No</th>
                <th data-priority="2">NIK</th>
                <th data-priority="3">No KK</th>
                <th data-priority="4">Nama Lengkap</th>
                <th data-priority="5">Jenis Kelamin</th>
                <th data-priority="6">Tanggal Lahir</th>
                <th data-priority="7">SHDK</th>
                <th data-priority="8">BPJS</th>
                <th data-priority="9">Faskes</th>
                <th data-priority="10">Pendidikan</th>
                <th data-priority="11">Pekerjaan</th>
                <th data-priority="12">Alamat</th>
                <th data-priority="13">RT</th>
                <th data-priority="14">RW</th>
                <th data-priority="15">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    `);
    
    var table = $('#penduduk-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('penduduk.index') }}",
            type: 'GET',
            error: function(xhr, error, code) {
                console.log('DataTable AJAX Error:', xhr, error, code);
                alert('Error loading data. Please refresh the page.');
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nik', name: 'nik' },
            { data: 'no_kk', name: 'no_kk' },
            { data: 'nama', name: 'nama' },
            { data: 'jenis_kelamin', name: 'jenis_kelamin' },
            { data: 'tanggal_lahir', name: 'tanggal_lahir' },
            { data: 'shdk', name: 'shdk' },
            { data: 'bpjs', name: 'bpjs' },
            { data: 'faskes', name: 'faskes' },
            { data: 'pendidikan', name: 'pendidikan' },
            { data: 'pekerjaan', name: 'pekerjaan' },
            { data: 'alamat', name: 'alamat' },
            { data: 'rt', name: 'rt' },
            { data: 'rw', name: 'rw' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...',
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_ (Total: _TOTAL_ data)",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya", 
                previous: "Sebelumnya"
            }
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        // Additional settings to prevent conflicts
        destroy: true,
        stateSave: false
    });
    
    // Refresh table after successful form submission
    window.refreshPendudukTable = function() {
        table.ajax.reload(null, false); // false = keep current page
    };
}

function editPenduduk(nik) {
    // Load edit modal content via AJAX
    $.get('/penduduk/edit/' + nik, function(data) {
        $('body').append(data);
        $('#edit' + nik).modal('show');
        
        // Remove modal from DOM when closed
        $('#edit' + nik).on('hidden.bs.modal', function () {
            $(this).remove();
        });
    }).fail(function() {
        alert('Error loading edit form');
    });
}

function deletePenduduk(nik) {
    // Load delete modal content via AJAX
    $.get('/penduduk/delete-modal/' + nik, function(data) {
        $('body').append(data);
        $('#delete' + nik).modal('show');
        
        // Remove modal from DOM when closed
        $('#delete' + nik).on('hidden.bs.modal', function () {
            $(this).remove();
        });
    }).fail(function() {
        alert('Error loading delete form');
    });
}
</script>
@endsection

@include('includes.add_data_penduduk')
{{-- Modals will be loaded dynamically via AJAX when needed --}}