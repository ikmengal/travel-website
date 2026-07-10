<script>

$(function () {

    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Select2
    |--------------------------------------------------------------------------
    */

    $('.select2').select2({
        width: '100%'
    });

    /*
    |--------------------------------------------------------------------------
    | DataTable
    |--------------------------------------------------------------------------
    */

    let table = $('#bookingTable').DataTable({

        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        order: [[10, 'desc']],

        ajax: {

            url: "{{ route('bookings.index') }}",

            data: function (d) {

                d.loaddata = "yes";

                d.search            = $('#search').val();

                d.customer          = $('#customer_filter').val();

                d.tour              = $('#tour_filter').val();

                d.departure         = $('#departure_filter').val();

                d.booking_status    = $('#booking_status_filter').val();

                d.payment_status    = $('#payment_status_filter').val();

                d.date_from         = $('#date_from').val();

                d.date_to           = $('#date_to').val();

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
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },

            {
                data: 'booking_no',
                name: 'booking_no'
            },

            {
                data: 'customer',
                name: 'user.name'
            },

            {
                data: 'tour',
                name: 'tour.title'
            },

            {
                data: 'departure',
                name: 'departure.departure_date'
            },

            {
                data: 'travelers',
                name: 'travelers',
                searchable: false
            },

            {
                data: 'grand_total',
                name: 'grand_total'
            },

            {
                data: 'payment_status',
                name: 'payment_status'
            },

            {
                data: 'booking_status',
                name: 'booking_status'
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

    /*
    |--------------------------------------------------------------------------
    | Filter Button
    |--------------------------------------------------------------------------
    */

    $('#filterBtn').click(function () {

        table.ajax.reload();

    });

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    $('#search').keyup(function (e) {

        if (e.keyCode == 13) {

            table.ajax.reload();

        }

    });

        /*
    |--------------------------------------------------------------------------
    | Tour → Departure AJAX
    |--------------------------------------------------------------------------
    */

    $('#tour_filter').on('change', function () {

        let tourId = $(this).val();

        $('#departure_filter').html(
            '<option value="">Loading...</option>'
        );

        if (tourId == '') {

            $('#departure_filter').html(
                '<option value="">All Departures</option>'
            );

            return;

        }

        $.ajax({

            url: "{{ route('bookings.getDepartures') }}",

            type: "GET",

            data: {
                tour_id: tourId
            },

            success: function (response) {

                let option = '<option value="">All Departures</option>';

                $.each(response, function (index, item) {

                    option += `
                        <option value="${item.id}">
                            ${item.departure_date}
                            →
                            ${item.return_date}
                        </option>
                    `;

                });

                $('#departure_filter')
                    .html(option)
                    .trigger('change');

            },

            error: function () {

                toastr.error('Unable to load departures.');

                $('#departure_filter').html(
                    '<option value="">All Departures</option>'
                );

            }

        });

    });

    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    $('#resetBtn').click(function () {

        $('#search').val('');

        $('#customer_filter').val('').trigger('change');

        $('#tour_filter').val('').trigger('change');

        $('#departure_filter')
            .html('<option value="">All Departures</option>')
            .trigger('change');

        $('#booking_status_filter')
            .val('')
            .trigger('change');

        $('#payment_status_filter')
            .val('')
            .trigger('change');

        $('#date_from').val('');

        $('#date_to').val('');

        table.ajax.reload();

    });

    /*
    |--------------------------------------------------------------------------
    | Check All
    |--------------------------------------------------------------------------
    */

    $('#checkAll').on('click', function () {

        $('.booking-checkbox').prop(
            'checked',
            $(this).is(':checked')
        );

    });

    $(document).on('change', '.booking-checkbox', function () {

        $('#checkAll').prop(

            'checked',

            $('.booking-checkbox:checked').length
            ==
            $('.booking-checkbox').length

        );

    });

        /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    $('#bulkDeleteBtn').click(function () {

        let ids = [];

        $('.booking-checkbox:checked').each(function () {

            ids.push($(this).val());

        });

        if (ids.length == 0) {

            toastr.warning('Please select at least one booking.');

            return;

        }

        Swal.fire({

            title: 'Are you sure?',

            text: "Selected bookings will be deleted permanently.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Yes, Delete'

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "{{ route('bookings.bulkDelete') }}",

                    type: "POST",

                    data: {
                        ids: ids
                    },

                    success: function (response) {

                        toastr.success(response.message);

                        table.ajax.reload();

                        $('#checkAll').prop('checked', false);

                    },

                    error: function () {

                        toastr.error('Something went wrong.');

                    }

                });

            }

        });

    });

    /*
    |--------------------------------------------------------------------------
    | Auto Reload On Filter Change
    |--------------------------------------------------------------------------
    */

    $('#customer_filter, #departure_filter, #booking_status_filter, #payment_status_filter')
        .on('change', function () {

            table.ajax.reload();

        });

    $('#date_from, #date_to').on('change', function () {

        table.ajax.reload();

    });

    /*
    |--------------------------------------------------------------------------
    | Refresh Every 60 Seconds (Optional)
    |--------------------------------------------------------------------------
    */

    // setInterval(function () {
    //     table.ajax.reload(null, false);
    // }, 60000);

});
</script>
