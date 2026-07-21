<script>
    $(function () {
        // ==========================================================
        // CSRF Token
        // ==========================================================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ==========================================================
        // Auto Slug Generator
        // ==========================================================
        $('#name').on('keyup blur', function () {
            let slug = $(this).val()
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            $('#slug').val(slug);
        });

        // ==========================================================
        // Clear Validation Errors
        // ==========================================================
        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').html('');
        }

        // ==========================================================
        // Reset Submit Button
        // ==========================================================
        function resetButton(btn) {
            btn.prop('disabled', false);
            btn.html(`
                <i class="ti ti-device-floppy me-1"></i>
                {{ isset($blogTag) ? 'Update Tag' : 'Save Tag' }}
            `);
        }

        // ==========================================================
        // AJAX Submit
        // ==========================================================
        $('#blogTagForm').submit(function (e) {
            e.preventDefault();
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
                    toastr.success(
                        response.message ??
                        'Blog tag saved successfully.'
                    );
                    setTimeout(function () {
                        window.location.href =
                            "{{ route('blog_tags.index') }}";
                    }, 500);
                },
                error: function (xhr) {
                    resetButton(btn);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            $('[name="' + field + '"]').addClass('is-invalid');
                            $('.' + field + '_error').html(messages[0]);
                        });
                        toastr.warning(
                            'Please fill all required fields.'
                        );
                        return;
                    }
                    if (xhr.status === 403) {
                        toastr.error(
                            xhr.responseJSON.message ??
                            'You are not authorized.'
                        );
                        return;
                    }
                    if (xhr.status === 404) {
                        toastr.error(
                            xhr.responseJSON.message ??
                            'Record not found.'
                        );
                        return;
                    }
                    if (xhr.status === 500) {
                        toastr.error(
                            xhr.responseJSON.message ??
                            'Internal server error.'
                        );
                        console.log(xhr.responseText);
                        return;
                    }
                    toastr.error('Something went wrong.');
                }
            });
        });
    });
</script>
