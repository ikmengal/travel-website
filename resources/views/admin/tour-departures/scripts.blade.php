<script>

$(function () {

    // ======================================================
    // SELECT2
    // ======================================================

    $('.select2').select2({
        width: '100%'
    });

    // ======================================================
    // DATATABLE
    // ======================================================

    let table = $('#tourDepartureTable').DataTable({

        processing: true,

        serverSide: true,

        responsive: false,

        autoWidth: false,

        pageLength: 25,

        order: [[7, 'desc']],

        ajax: {

            url: "{{ route('tour_departures.index') }}",

            data: function (d) {

                d.loaddata = "yes";

                d.tour = $('#tour_filter').val();

                d.status = $('#status_filter').val();

                d.departure_date = $('#departure_filter').val();

                d.search = $('#search').val();

            }

        },

        columns: [

            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },

            {
                data: 'tour',
                name: 'tour.title'
            },

            {
                data: 'departure_date',
                name: 'departure_date'
            },

            {
                data: 'return_date',
                name: 'return_date'
            },

            {
                data: 'price',
                name: 'price'
            },

            {
                data: 'available_seats',
                name: 'available_seats'
            },

            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },

            {
                data: 'created_at',
                name: 'created_at'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

    // ======================================================
    // FILTERS
    // ======================================================

    $('#tour_filter').change(function () {

        table.draw();

    });

    $('#status_filter').change(function () {

        table.draw();

    });

    $('#departure_filter').change(function () {

        table.draw();

    });

    $('#search').keyup(function () {

        table.draw();

    });

    // ======================================================
    // REFRESH
    // ======================================================

    $('#refreshTable').click(function () {

        table.ajax.reload(null, false);

    });

    // ======================================================
    // CHECK ALL
    // ======================================================

    $(document).on('change', '#checkAll', function () {

        $('.row-checkbox').prop('checked', $(this).is(':checked'));

        toggleBulkDelete();

    });

    $(document).on('change', '.row-checkbox', function () {

        toggleBulkDelete();

        if (!$(this).is(':checked')) {

            $('#checkAll').prop('checked', false);

        }

    });

    function toggleBulkDelete() {

        let total = $('.row-checkbox:checked').length;

        if (total > 0) {

            $('#bulkDelete').removeClass('d-none');

        } else {

            $('#bulkDelete').addClass('d-none');

        }

    }

    // ======================================================
    // BULK DELETE
    // ======================================================

    $(document).on('click', '#bulkDelete', function () {

        let ids = [];

        $('.row-checkbox:checked').each(function () {

            ids.push($(this).val());

        });

        if (ids.length == 0) {

            return;

        }

        Swal.fire({

            title: 'Delete Selected Departures?',

            text: 'This action cannot be undone.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#8592a3',

            confirmButtonText: 'Delete'

        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({

                url: "{{ route('tour_departures.bulk-delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    ids: ids

                },

                success: function (response) {

                    toastr.success(response.message);

                    table.ajax.reload(null, false);

                    $('#checkAll').prop('checked', false);

                    $('#bulkDelete').addClass('d-none');

                },

                error: function () {

                    toastr.error('Delete failed.');

                }

            });

        });

    });

    // ======================================================
    // STATUS
    // ======================================================

    $(document).on('change', '.changeStatus', function () {

        let id = $(this).data('id');

        $.ajax({

            url: "{{ route('tour_departures.change-status') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                id: id

            },

            success: function (response) {

                toastr.success(response.message);

                table.ajax.reload(null, false);

            },

            error: function () {

                toastr.error('Unable to update status.');

                table.ajax.reload(null, false);

            }

        });

    });

    // ======================================================
    // DELETE
    // ======================================================

    $(document).on('click', '.deleteRecord', function (e) {

        e.preventDefault();

        let url = $(this).data('url');

        Swal.fire({

            title: 'Delete Departure?',

            text: 'This action cannot be undone.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#8592a3',

            confirmButtonText: 'Delete'

        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({

                url: url,

                type: "DELETE",

                data: {

                    _token: "{{ csrf_token() }}"

                },

                success: function (response) {

                    toastr.success(response.message);

                    table.ajax.reload(null, false);

                },

                error: function () {

                    toastr.error('Delete failed.');

                }

            });

        });

    });

    // ======================================================
    // LIVE SUMMARY (CREATE / EDIT)
    // ======================================================

    $('input[name="departure_date"]').change(function () {

        $('#departurePreview').text($(this).val());

    });

    $('input[name="return_date"]').change(function () {

        $('#returnPreview').text($(this).val());

    });

    $('input[name="available_seats"]').keyup(function () {

        let seats = $(this).val();

        if (seats == '') {

            seats = 0;

        }

        $('#seatPreview').text(seats);

    });

});

</script>
