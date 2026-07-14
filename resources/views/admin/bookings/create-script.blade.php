<script>
    $(function () {
        // ---------------- CSRF ---------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ---------------- Select2 ---------------- //
        $('.select2').select2({
            width: '100%'
        });

        // ---------------- CKEditor (Optional) ---------------- //
        if ($('#special_request').length) {
            CKEDITOR.replace('special_request');
        }

        // ---------------- Load Tour Departures ---------------- //
        $('#tour_id').change(function () {
            let tourId = $(this).val();

            $('#tour_departure_id').html(
                '<option>Loading...</option>'
            );

            if (tourId == '') {
                $('#tour_departure_id').html(
                    '<option value="">Select Departure</option>'
                );
                calculateTotal();
                return;
            }

            $.ajax({
                url: "{{ route('bookings.get-departures') }}",
                type: "POST",
                data: {
                    tour_id: tourId
                },
                success: function (response) {
                    let html = '<option value="">Select Departure</option>';
                    $.each(response, function (key, item) {
                        html += `
                            <option value="${item.id}">
                                ${item.departure_date}
                                →
                                ${item.return_date}
                            </option>
                        `;
                    });
                    $('#tour_departure_id').html(html);
                }
            });

            // ---------------- Tour Price ---------------- //
            let price = $(this).find(':selected').data('price') || 0;
            $('#tour_price').val(price);
            calculateTotal();
        });

        // ---------------- Auto Calculation ---------------- //
        $('#adults,#children,#infants,#discount,#tax').on(
            'keyup change',
            function () {
                calculateTotal();
            }
        );

        function calculateTotal()
        {
            let adults = parseInt($('#adults').val()) || 0;

            let children = parseInt($('#children').val()) || 0;

            let infants = parseInt($('#infants').val()) || 0;

            let totalTravelers = adults + children + infants;

            $('#total_travelers').val(totalTravelers);

            $('#summaryTravelers').text(totalTravelers);

            let tourPrice = parseFloat($('#tour_price').val()) || 0;

            let subtotal = totalTravelers * tourPrice;

            $('#subtotal').val(subtotal.toFixed(2));

            let discount = parseFloat($('#discount').val()) || 0;

            let tax = parseFloat($('#tax').val()) || 0;

            let grandTotal = subtotal - discount + tax;

            $('#grand_total').val(grandTotal.toFixed(2));

            // ---------------- Summary ---------------- //
            $('#summaryPrice').text(subtotal.toFixed(2));

            $('#summaryDiscount').text(discount.toFixed(2));

            $('#summaryTax').text(tax.toFixed(2));

            $('#summaryGrandTotal').text(grandTotal.toFixed(2));
        }

        // ---------------- Initial Calculate ---------------- //
        calculateTotal();

        // ----------------  Form Validation ---------------- //
        $('#bookingForm').submit(function () {
            if ($('#special_request').length) {
                CKEDITOR.instances.special_request.updateElement();
            }

            let user = $('#user_id').val();
            let tour = $('#tour_id').val();

            if (user == '') {
                toastr.error('Please select customer.');
                return false;
            }

            if (tour == '') {
                toastr.error('Please select a tour.');
                return false;
            }
            return true;
        });
    });
</script>
