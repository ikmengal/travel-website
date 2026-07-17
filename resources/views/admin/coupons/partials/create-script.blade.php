<script>
    $(function () {
        // -------------- Generate Coupon Code -------------- //
        $('#generateCode').on('click', function () {
            $.ajax({
                url: "{{ route('coupons.generate-code') }}",
                type: "GET",
                beforeSend: function () {
                    $('#generateCode')
                        .prop('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm"></span>');
                },
                success: function (response) {
                    if (response.status) {
                        $('#code').val(response.code);
                        toastr.success('Coupon code generated successfully.');
                    }
                },
                error: function () {
                    toastr.error('Unable to generate coupon code.');
                },
                complete: function () {
                    $('#generateCode').prop('disabled', false).html('Generate');
                }
            });
        });

        // -------------- CKEditor 4 -------------- //
        if ($('#description').length) {
            CKEDITOR.replace('description', {
                height: 180,
                removeButtons: 'PasteFromWord'
            });
        }

        // -------------- Discount Type Logic -------------- //
        function toggleMaximumDiscount() {
            let type = $('#type').val();

            if (type === 'percentage') {
                $('#maximum_discount')
                    .prop('readonly', false)
                    .closest('.col-md-6')
                    .find('small')
                    .removeClass('text-danger')
                    .addClass('text-muted')
                    .text('Maximum discount applies to percentage coupons.');
            } else {
                $('#maximum_discount')
                    .val('')
                    .prop('readonly', true)
                    .closest('.col-md-6')
                    .find('small')
                    .removeClass('text-muted')
                    .addClass('text-danger')
                    .text('Maximum discount is not applicable for fixed coupons.');
            }
        }

        toggleMaximumDiscount();

        $('#type').on('change', function () {
            toggleMaximumDiscount();
        });

        // -------------- Auto Uppercase Coupon Code -------------- //
        $('#code').on('keyup blur', function () {
            $(this).val($(this).val().toUpperCase());
        });

        // -------------- Expiry Date Validation -------------- //
        $('input[name="starts_at"]').on('change', function () {
            $('input[name="expires_at"]').attr('min', $(this).val());
        });

        // -------------- Form Submit -------------- //
        $('#couponForm').on('submit', function () {
            if (typeof CKEDITOR !== 'undefined') {
                for (let instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }
        });
    });
</script>
