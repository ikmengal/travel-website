<script>
    $(function () {
        // ------------
        // CSRF Token
        // ------------
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ------------
        // CKEditor 4
        // ------------
        if ($('#description').length) {
            CKEDITOR.replace('description', {
                height: 250
            });
        }

        // ------------
        // Auto Slug Generate
        // ------------
        $('#name').on('keyup blur', function () {
            let slug = $(this).val()
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            $('#slug').val(slug);
        });

        // ------------
        // Meta Title Counter
        // ------------
        $('#meta_title').on('keyup', function () {
            $('#metaTitleCount').text($(this).val().length);
        });

        // ------------
        // Meta Description Counter
        // ------------
        $('#meta_description').on('keyup', function () {
            $('#metaDescriptionCount').text($(this).val().length);
        });

        // ------------
        // Initial Counter Values
        // ------------
        $('#metaTitleCount').text($('#meta_title').val().length);
        $('#metaDescriptionCount').text($('#meta_description').val().length);

        // ------------
        // Clear Validation Errors
        // ------------
        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('[class$="_error"]').html('');
            if (CKEDITOR.instances.description) {
                $('#cke_description').css('border', '');
            }
        }

        // ------------
        // Reset Button State
        // ------------
        function resetButton(btn) {
            btn.prop('disabled', false);
            btn.html(`
                <i class="ti ti-device-loppy me-1"></i>
                Save Category
            `);
        }

        // ------------
        // AJAX Submit
        // ------------
        $('#blogCategoryForm').submit(function (e) {
            e.preventDefault();

            // Update CKEditor Data
            for (let instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            clearValidationErrors();
            let form = this;
            let btn = $('#submitBtn');
            let formData = new FormData(form);
            btn.prop('disabled', true);

            btn.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Please Wait...
            `);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    resetButton(btn);
                    toastr.success(response.message ?? 'Blog category saved successfully.');
                    setTimeout(function () {
                        window.location.href = "{{ route('blog_categories.index') }}";
                    }, 500);
                },
                error: function (xhr) {
                    resetButton(btn);
                    // Validation Error
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            $('[name="' + field + '"]').addClass('is-invalid');
                            $('.' + field + '_error').html(messages[0]);
                        });
                        if (errors.description) {
                            $('#cke_description').css({
                                border: '1px solid #ea5455',
                                borderRadius: '6px'
                            });
                        }
                        toastr.warning('Please fix the validation errors.');
                        return;
                    }
                    // Unauthorized
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message ?? 'Unauthorized.');
                        return;
                    }

                    // Record Not Found
                    if (xhr.status === 404) {
                        toastr.error(xhr.responseJSON.message ?? 'Record not found.');
                        return;
                    }

                    // Server Error
                    if (xhr.status === 500) {
                        toastr.error(xhr.responseJSON.message ?? 'Internal server error.');
                        console.log(xhr.responseText);
                        return;
                    }
                    toastr.error('Something went wrong.');
                }
            });
        });
    });
</script>
