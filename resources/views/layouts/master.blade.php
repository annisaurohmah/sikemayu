<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>SIKEMAYU</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

    <!-- jQuery (required for Bootstrap 4) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Popper.js (for tooltip/dropdown/tab) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

            // Saat tab diklik
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href'); // #format2 misalnya
                const table = $(target).find('table');
                const tableId = table.attr('id');
                if (tableId) {
                    initDataTable(tableId);
                }
            });
        });
    </script>


</body>

</html>