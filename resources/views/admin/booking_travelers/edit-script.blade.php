<script>
    $(function () {
        // ------------ Select2 ------------ //
        $('.select2').select2({
            width: '100%'
        });

        // ------------ CKEditor 4 ------------ //
        if ($('#notes').length) {
            CKEDITOR.replace('notes', {
                height: 180
            });
        }

        // ------------ Load Booking Details ------------ //
        function loadBookingDetails(bookingId)
        {
            $('#customer_name').val('');
            $('#tour_name').val('');

            if (bookingId == '') {
                return;
            }
            $.ajax({
                url: "{{ route('booking_travelers.get-bookings') }}",
                type: "GET",
                data: {
                    booking_id: bookingId
                },
                success: function (response) {
                    $('#customer_name').val(response.customer);
                    $('#tour_name').val(response.tour);
                },
                error: function () {
                    toastr.error('Unable to load booking details.');
                }
            });
        }

        // ------------ Booking Change ------------ //
        $('#booking_id').on('change', function () {
            loadBookingDetails($(this).val());
        });

        // ------------ Load Existing Booking ------------ //
        if ($('#booking_id').val() != '') {
            loadBookingDetails($('#booking_id').val());
        }

        // ------------ Status Switch ------------ //
        $('input[name="status"]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });

        // ------------ Sync CKEditor Before Submit ------------ //
        $('#travelerForm').on('submit', function () {
            if (typeof CKEDITOR !== 'undefined') {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        });
    });
</script>
