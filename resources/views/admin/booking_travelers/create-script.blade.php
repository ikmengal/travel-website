<script>
    $(function () {
        // ------------- Select2 ------------- //
        $('.select2').select2({
            width: '100%'
        });

        // ------------- CKEditor 4 ------------- //
        if ($('#notes').length) {
            CKEDITOR.replace('notes', {
                height: 180
            });
        }

        // ------------- Load Booking Details ------------- //
        $('#booking_id').on('change', function () {
            let bookingId = $(this).val();

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
                    console.log(response);
                    $('#customer_name').val(response.customer);
                    $('#tour_name').val(response.tour);
                },
                error: function () {
                    console.log(response);
                    toastr.error('Unable to load booking details.');
                }
            });
        });

        // ------------- Trigger on Edit / Old Value ------------- //
        if ($('#booking_id').val() != '') {
            $('#booking_id').trigger('change');
        }

        // ------------- Status Switch ------------- //
        $('input[name="status"]').on('change', function () {
            if ($(this).is(':checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
    });
</script>
