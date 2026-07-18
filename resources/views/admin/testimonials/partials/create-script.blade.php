<script>
    $(function () {
        "use strict";
        // --------------- CSRF Token --------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // --------------- Select2 --------------- //
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select Option',
            allowClear: true
        });

        // --------------- CKEditor 4 --------------- //
        if ($('#review').length) {
            CKEDITOR.replace('review', {
                height: 200,
                removeButtons: 'PasteFromWord',
                // extraPlugins: 'justify'
            });
        }

        // --------------- Image Preview --------------- //
        $('#image').on('change', function (e) {
            let file = e.target.files[0];
            if (!file) {
                return;
            }

            // --------------- Image Validation --------------- //
            let allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'image/webp'
            ];

            if ($.inArray(file.type, allowedTypes) === -1) {
                toastr.warning(
                    'Only JPG, JPEG, PNG and WEBP images are allowed.'
                );
                $(this).val('');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                toastr.warning(
                    'Image size must not exceed 2MB.'
                );
                $(this).val('');
                return;
            }

            let reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        // --------------- Remove Validation Errors --------------- //
        $(document).on(
            'keyup change',
            'input, textarea, select',
            function () {
                $(this).removeClass('is-invalid');
                let field = $(this).attr('name');
                $('.' + field + '_error').html('');
            }
        );

        // --------------- Reset Validation Errors --------------- //
        function clearValidationErrors() {
            $('.text-danger').html('');
            $('.is-invalid').removeClass('is-invalid');
        }

        // --------------- Reset Submit Button --------------- //
        function resetButton(btn) {
            btn.prop('disabled', false);
            btn.html(`
                <i class="ti ti-device-floppy me-1"></i>
                {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}
            `);
        }

        // --------------- AJAX Submit --------------- //
        $('#testimonialForm').submit(function (e) {
            e.preventDefault();
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

                // --------------- Success --------------- //
                success: function (response) {
                    btn.prop('disabled', false);
                    btn.html(`
                        <i class="ti ti-device-floppy me-1"></i>
                        {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}
                    `);
                    toastr.success(response.message ?? "Testimonial saved successfully.");

                    // --------------- Redirect --------------- //
                    setTimeout(function () {
                        window.location.href = "{{ route('testimonials.index') }}";
                    }, 500);
                },
                // --------------- Error --------------- //
                error: function (xhr) {
                    resetButton(btn);
                    // --------------- Validation Errors --------------- //
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            $('[name="' + field + '"]').addClass('is-invalid');
                            $('.' + field + '_error').html(messages[0]);
                        });

                        // CKEditor Border
                        if (errors.review) {
                            $('#cke_review').css('border', '1px solid #ea5455');
                        }
                        toastr.warning("Please fill all required fields.");
                        return;
                    }
                    // --------------- Unauthorized --------------- //
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message ?? "You are not authorized.");
                        return;
                    }
                    // --------------- Record Not Found --------------- //
                    if (xhr.status === 404) {
                        toastr.error(xhr.responseJSON.message ?? "Record not found.");
                        return;
                    }
                    // --------------- Internal Server Error --------------- //
                    if (xhr.status === 500) {
                        toastr.error(xhr.responseJSON.message ?? "Internal server error.");
                        console.log(xhr.responseText);
                        return;
                    }
                    // --------------- Default --------------- //
                    toastr.error("Something went wrong.");
                }
            });
        });

        // --------------- Remove CKEditor Validation Border --------------- //
        if (CKEDITOR.instances.review) {
            CKEDITOR.instances.review.on('change', function () {
                $('#cke_review').css('border', '');
                $('.review_error').html('');
            });
        }

        // --------------- Reset Form --------------- //
        $('button[type="reset"]').on('click', function () {
            clearValidationErrors();
            // ---------------- Reset Select2 ---------------- //
            $('.select2').val(null).trigger('change');

            // ---------------- Reset CKEditor ---------------- //
            if (CKEDITOR.instances.review) {
                CKEDITOR.instances.review.setData('');
                $('#cke_review').css('border', '');
            }

            // ---------------- Reset Preview Image ---------------- //
            let defaultImage = $('#imagePreview').data('default');
            if (defaultImage) {
                $('#imagePreview').attr('src', defaultImage);
            }
        });

        // --------------- Prevent Double Click Submit --------------- //
        $(document).on('click', '#submitBtn', function () {
            if ($(this).prop('disabled')) {
                return false;
            }
        });

        // --------------- Remove Image Validation --------------- //
        $('#image').on('click change', function () {
            $(this).removeClass('is-invalid');
            $('.image_error').html('');
        });

        // --------------- Character Counter (Meta Title) --------------- //
        $(document).on('keyup', '[name="meta_title"]', function () {
            let length = $(this).val().length;
            $('#metaTitleCount').html(length);
        });

        // --------------- Character Counter (Meta Description) --------------- //
        $(document).on('keyup', '[name="meta_description"]', function () {
            let length = $(this).val().length;
            $('#metaDescriptionCount').html(length);
        });

        // --------------- Prevent Enter Key Submit --------------- //
        $(document).on('keypress', 'input', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

        // --------------- Tooltips --------------- //
        $('[data-bs-toggle="tooltip"]').tooltip();

        // --------------- Page Ready --------------- //
        console.log('Testimonials Form Loaded Successfully.');
    });
</script>
