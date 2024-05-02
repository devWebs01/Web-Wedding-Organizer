@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">
    <style>
        table.dataTable thead tr,
        table.dataTable thead th,
        table.dataTable tbody th,
        table.dataTable tbody td {
            text-align: center;
        }

    </style>
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"z></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"z></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"z></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.js"z></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.js"z></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/searchBuilder.bootstrap5.js"z></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"z></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"z></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"z></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"z></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"z></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"z></script>
    <script>
        $('table.display').DataTable({
            layout: {
                top1: 'searchBuilder',
                topStart: {
                    buttons: ['excel', 'print']
                }
            }
        });
    </script>
@endpush
