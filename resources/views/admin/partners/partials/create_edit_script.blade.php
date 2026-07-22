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

        // -------------------- Image Preview -------------------- //
        $('#logo').on('change', function () {
            let file = this.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#logoPreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // -------------------- Clear Validation -------------------- //
        function clearErrors() {
            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');
            $('.form-select').removeClass('is-invalid');
        }

        // -------------------- Submit -------------------- //
        $('#partnerForm').submit(function (e) {
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
                    window.location.href = "{{ route('partners.index') }}";
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
