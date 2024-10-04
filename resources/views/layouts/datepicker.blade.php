@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush


@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            var today = moment().format('DD/MM/YYYY'); // Mendapatkan tanggal hari ini dengan format "DD/MM/YYYY"

            $('input[name="datepicker"]').daterangepicker({
                opens: 'center',
                minDate: today,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY' // Set format tampilan penanggalan di input
                },
                // maxDate: parseInt(moment().format('MM/DD/YYYY'), 10)
            });
        });
    </script>
@endpush
