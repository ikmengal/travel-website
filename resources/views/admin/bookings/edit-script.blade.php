<script>

$(function () {

    /*
    |--------------------------------------------------------------------------
    | Ajax Setup
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
    | CKEditor 4
    |--------------------------------------------------------------------------
    */

    if ($('#special_request').length) {

        CKEDITOR.replace('special_request');

    }

    /*
    |--------------------------------------------------------------------------
    | Tour Change
    |--------------------------------------------------------------------------
    */

    $('#tour_id').change(function () {

        let tourId = $(this).val();

        let selectedDeparture = "{{ old('tour_departure_id', $booking->tour_departure_id) }}";

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

            url: "{{ route('bookings.getDepartures') }}",

            type: "GET",

            data: {
                tour_id: tourId
            },

            success: function (response) {

                let html = '<option value="">Select Departure</option>';

                $.each(response, function (key, item) {

                    let selected = item.id == selectedDeparture
                        ? 'selected'
                        : '';

                    html += `
                        <option value="${item.id}" ${selected}>
                            ${item.departure_date}
                            →
                            ${item.return_date}
                        </option>
                    `;

                });

                $('#tour_departure_id').html(html);

            }

        });

        let price = $(this).find(':selected').data('price') || 0;

        $('#tour_price').val(price);

        calculateTotal();

    });

    /*
    |--------------------------------------------------------------------------
    | Price Calculation
    |--------------------------------------------------------------------------
    */

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

        $('#summaryPrice').text(subtotal.toFixed(2));

        $('#summaryDiscount').text(discount.toFixed(2));

        $('#summaryTax').text(tax.toFixed(2));

        $('#summaryGrandTotal').text(grandTotal.toFixed(2));

    }

    /*
    |--------------------------------------------------------------------------
    | Initial Calculation
    |--------------------------------------------------------------------------
    */

    calculateTotal();

    /*
    |--------------------------------------------------------------------------
    | Form Validation
    |--------------------------------------------------------------------------
    */

    $('#bookingForm').submit(function () {

        if ($('#special_request').length) {

            CKEDITOR.instances.special_request.updateElement();

        }

        if ($('#user_id').val() == '') {

            toastr.error('Please select customer.');

            return false;

        }

        if ($('#tour_id').val() == '') {

            toastr.error('Please select a tour.');

            return false;

        }

        return true;

    });

});
</script>
