<script>
    $(function () {
        // =====================================================
        // CSRF Setup
        // =====================================================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // =====================================================
        // CKEditor 4
        // =====================================================
        if ($('#description').length) {

            CKEDITOR.replace('description', {
                height: 300
            });

        }

        // =====================================================
        // Image Preview
        // =====================================================
        $('#image').on('change', function (e) {

            const file = e.target.files[0];

            if (!file) {

                $('#imagePreview').hide();

                return;

            }

            const reader = new FileReader();

            reader.onload = function (event) {

                $('#imagePreview')
                    .attr('src', event.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        });

        // =====================================================
        // AJAX Submit
        // =====================================================
        $('#bannerForm').submit(function (e) {

            e.preventDefault();

            // Update CKEditor value
            if (CKEDITOR.instances.description) {

                CKEDITOR.instances.description.updateElement();

            }

            let form = this;

            let formData = new FormData(form);

            // Remove Previous Errors
            $('.is-invalid').removeClass('is-invalid');

            $('.invalid-feedback').html('');

            $('#submitBtn')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            $.ajax({

                url: $(form).attr('action'),

                method: $(form).attr('method'),

                data: formData,

                processData: false,

                contentType: false,

                success: function (response) {

                    toastr.success(response.message);

                    window.location.href = "{{ route('banners.index') }}";

                },

                error: function (xhr) {

                    $('#submitBtn')
                        .prop('disabled', false)
                        .html('<i class="ti ti-device-floppy me-1"></i> Save Banner');

                    if (xhr.status === 422) {

                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function (key, value) {

                            let field = $('[name="' + key + '"]');

                            if (!field.length) {
                                field = $('[name="' + key + '[]"]');
                            }

                            field.addClass('is-invalid');

                            $('.' + key.replace(/\./g, '_') + '_error')
                                .text(value[0]);

                        });

                    } else {

                        toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');

                    }

                }

            });

        });

    });
</script>
