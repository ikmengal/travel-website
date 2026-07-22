<script>
$(function () {

    // -------------------- CSRF -------------------- //
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // -------------------- Select2 -------------------- //
    $('.select2').select2({
        width: '100%'
    });

    // -------------------- Live Icon Preview -------------------- //
    $('#icon').on('keyup change', function () {

        let icon = $(this).val().trim();

        if (icon === '') {
            icon = 'ti ti-users';
        }

        $('#iconPreview')
            .attr('class', '')
            .addClass(icon + ' fs-4');

    });

    // -------------------- Clear Validation -------------------- //
    function clearErrors() {

        $('.error-text').text('');

        $('.form-control').removeClass('is-invalid');

        $('.form-select').removeClass('is-invalid');

    }

    // -------------------- AJAX Submit -------------------- //
    $('#counterForm').on('submit', function (e) {

        e.preventDefault();

        clearErrors();

        let btn = $('#submitBtn');

        btn.prop('disabled', true);

        btn.html(
            '<span class="spinner-border spinner-border-sm me-1"></span>Saving...'
        );

        let formData = new FormData(this);

        @isset($counter)
            formData.append('_method', 'PUT');
        @endisset

        $.ajax({

            url: @isset($counter)
                    "{{ route('counters.update', $counter->id) }}"
                 @else
                    "{{ route('counters.store') }}"
                 @endisset,

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            cache: false,

            success: function (response) {

                toastr.success(response.message);

                window.location.href = "{{ route('counters.index') }}";

            },

            error: function (xhr) {

                btn.prop('disabled', false);

                btn.html(
                    '<i class="ti ti-device-floppy me-1"></i> @isset($counter) Update Counter @else Save Counter @endisset'
                );

                if (xhr.status === 422) {

                    $.each(xhr.responseJSON.errors, function (key, value) {

                        $('[name="' + key + '"]').addClass('is-invalid');

                        $('.' + key + '_error').text(value[0]);

                    });

                } else {

                    toastr.error(
                        xhr.responseJSON.message ?? 'Something went wrong.'
                    );

                }

            }

        });

    });

});
</script>
