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
        // Select2
        // =====================================================

        $('.select2').select2({
            width: '100%'
        });

        // =====================================================
        // CKEditor 4
        // =====================================================

        if ($('#description').length) {

            CKEDITOR.replace('description', {
                height: 350
            });

        }

        // =====================================================
        // Auto Slug
        // =====================================================

        $('#title').on('keyup blur', function () {

            let slug = $(this).val()
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-');

            $('#slug').val(slug);

        });

        // =====================================================
        // Image Preview
        // =====================================================

        $('#featured_image').change(function (e) {

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
        // Form Submit
        // =====================================================

        $('#pageForm').submit(function (e) {

            e.preventDefault();

            if (CKEDITOR.instances.description) {

                CKEDITOR.instances.description.updateElement();

            }

            let form = this;

            let formData = new FormData(form);

            // Remove Old Errors
            $('.is-invalid').removeClass('is-invalid');

            $('.invalid-feedback').html('');

            $('#submitBtn')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

            $.ajax({

                url: $(form).attr('action'),

                type: $(form).attr('method'),

                data: formData,

                processData: false,

                contentType: false,

                success: function (response) {

                    toastr.success(response.message);

                    window.location.href = "{{ route('pages.index') }}";

                },

                error: function (xhr) {

                    $('#submitBtn')
                        .prop('disabled', false)
                        .html('<i class="ti ti-device-floppy me-1"></i> Save Page');

                    if (xhr.status === 422) {

                        $.each(xhr.responseJSON.errors, function (key, value) {

                            let input = $('[name="' + key + '"]');

                            if (!input.length) {

                                input = $('[name="' + key + '[]"]');

                            }

                            input.addClass('is-invalid');

                            $('.' + key.replace(/\./g, '_') + '_error')
                                .text(value[0]);

                        });

                    } else {

                        toastr.error(
                            xhr.responseJSON?.message ??
                            'Something went wrong.'
                        );

                    }

                }

            });

        });

    });
</script>
