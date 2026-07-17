<script>
    $(function () {
        // --------------- Select2 --------------- //
        $('.select2').select2({
            width: '100%'
        });

        // --------------- CKEditor 4 --------------- //
        if ($('#notes').length) {
            CKEDITOR.replace('notes', {
                height: 180
            });
        }

        // --------------- Receipt Preview --------------- //
        $('input[name="receipt"]').on('change', function () {
            let file = this.files[0];
            if (!file) {
                return;
            }

            if (file.type.startsWith('image/')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    if ($('#receiptPreview').length == 0) {
                        $('input[name="receipt"]').after(
                            '<div class="mt-3">' +
                            '<img id="receiptPreview" class="img-fluid rounded border" style="max-height:220px;">' +
                            '</div>'
                        );
                    }
                    $('#receiptPreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // --------------- Load Booking Details --------------- //
        function loadBookingDetails(bookingId)
        {
            if (bookingId == '') {
                $('#customer_name').val('');
                $('#tour_name').val('');
                $('#booking_total').val('');
                $('#booking_currency').val('');
                $('#amount').val('');
                $('#currency').val('');
                return;
            }

            $.ajax({
                url: "{{ route('payments.get-bookings') }}",
                type: "GET",
                data: {
                    booking_id: bookingId
                },
                success: function (response) {
                    if (response.status) {
                        $('#customer_name').val(response.customer);
                        $('#tour_name').val(response.tour);
                        $('#booking_total').val(response.grand_total);
                        $('#booking_currency').val(response.currency);
                        $('#amount').val(response.grand_total);
                        $('#currency').val(response.currency);
                    }
                },
                error: function () {
                    toastr.error('Unable to load booking information.');
                }
            });
        }

        // ---------------
        // Booking Change
        // ---------------

        $('#booking_id').on('change', function () {

            loadBookingDetails($(this).val());

        });

        // ---------------
        // Load Old Booking
        // ---------------

        if ($('#booking_id').val() != '') {

            loadBookingDetails($('#booking_id').val());

        }

        // ---------------
        // Status Switch
        // ---------------

        $('input[name="status"]').on('change', function () {

            $(this).val($(this).is(':checked') ? 1 : 0);

        });

        // ---------------
        // Sync CKEditor Before Submit
        // ---------------

        $('#paymentForm').on('submit', function () {

            if (typeof CKEDITOR !== 'undefined') {

                for (let instance in CKEDITOR.instances) {

                    CKEDITOR.instances[instance].updateElement();

                }

            }

        });

    });
</script>
