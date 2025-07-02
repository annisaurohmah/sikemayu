<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>SIKEMAYU</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CRITICAL FIX: Override the main wrapper height and overflow restrictions */
        #wrapper {
            height: auto !important;
            min-height: 100vh !important;
            overflow: visible !important;
            overflow-y: auto !important;
        }

        /* Fix scroll issues for long tables */
        html,
        body {
            overflow-x: auto !important;
            overflow-y: auto !important;
            height: auto !important;
            max-height: none !important;
            min-height: 100vh !important;
        }

        .content-page {
            overflow: visible !important;
            height: auto !important;
            max-height: none !important;
            min-height: calc(100vh - 70px) !important;
        }

        .content {
            overflow: visible !important;
            height: auto !important;
            max-height: none !important;
            padding-bottom: 50px !important;
        }

        .container-fluid {
            overflow: visible !important;
            height: auto !important;
            max-height: none !important;
        }

        .page-content-wrapper {
            overflow: visible !important;
            height: auto !important;
            max-height: none !important;
        }

        /* Ensure table container can scroll */
        .table-responsive {
            overflow-x: auto !important;
            overflow-y: visible !important;
            max-height: none !important;
            height: auto !important;
        }

        /* DataTable specific fixes */
        .dataTables_wrapper {
            overflow: visible !important;
            clear: both !important;
        }

        .card-body {
            overflow: visible !important;
            max-height: none !important;
            height: auto !important;
            padding-bottom: 30px !important;
        }

        .card {
            overflow: visible !important;
            max-height: none !important;
            height: auto !important;
            margin-bottom: 30px !important;
        }

        /* Fix for sidebar scroll issues */
        .left.side-menu {
            height: 100vh !important;
            overflow-y: auto !important;
        }

        /* Ensure page has proper bottom margin */
        .row:last-child {
            margin-bottom: 50px !important;
        }
    </style>

    @include('layouts.head')
</head>

<body>
    <div id="wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('layouts.settings')
                    @yield('content')
                </div>
            </div>
        </div>

        @include('layouts.footer')
        @include('layouts.footer-script')
    </div>

    @include('includes.flash')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Popper.js (for Bootstrap 4 tooltips) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 jika digunakan
            $('.select2').select2();

            // Fungsi untuk inisialisasi DataTable dengan tombol export
            function initDataTable(tableId) {
                if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
                        paging: true,
                        info: true,
                        lengthChange: true
                    });
                }
            }

            // Inisialisasi tabel di tab pertama
            initDataTable('datatable-buttons');

            // Saat tab diklik (Bootstrap 4 pakai data-toggle)
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href'); // #format2 misalnya
                const table = $(target).find('table');
                const tableId = table.attr('id');
                if (tableId) {
                    initDataTable(tableId);
                }
            });
        });
    </script>

    @yield('scripts')

    <style>
        /* Custom CSS untuk alignment sidebar menu */
        .side-dropdown li a {
            display: flex !important;
            align-items: center !important;
            padding: 8px 20px !important;
            text-decoration: none !important;
            color: inherit !important;
        }

        .side-dropdown li a i.icon-dot {
            width: 16px !important;
            height: 16px !important;
            margin-right: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
        }

        .side-dropdown li a span {
            flex: 1 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            line-height: 1.4 !important;
        }

        /* Ensure all dropdown items have consistent spacing */
        .side-dropdown li {
            margin: 0 !important;
            padding: 0 !important;
        }

        .side-dropdown {
            padding-left: 0 !important;
            list-style: none !important;
        }
    </style>

</body>

</html>