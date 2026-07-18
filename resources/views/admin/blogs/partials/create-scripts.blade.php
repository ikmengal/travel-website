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
    // Select2
    // ==========================================================

    $('.select2').select2({
        width: '100%'
    });

    // ==========================================================
    // CKEditor 4
    // ==========================================================

    if ($('#description').length) {

        CKEDITOR.replace('description', {
            height: 350
        });

    }

    // ==========================================================
    // Image Preview
    // ==========================================================

    $('#featured_image').change(function (e) {

        let reader = new FileReader();

        reader.onload = function (e) {

            $('#imagePreview').attr('src', e.target.result);

        }

        reader.readAsDataURL(e.target.files[0]);

    });

    // ==========================================================
    // Auto Slug
    // ==========================================================

    $('#title').on('keyup', function () {

        let slug = $(this).val()
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        $('#slug').val(slug);

    });

    // ==========================================================
    // Character Counter
    // ==========================================================

    function updateCounter(field, counter) {

        $(counter).text($(field).val().length);

    }

    updateCounter('#short_description','#shortDescriptionCount');

    updateCounter('#meta_title','#metaTitleCount');

    updateCounter('#meta_description','#metaDescriptionCount');

    $('#short_description').keyup(function(){

        updateCounter(this,'#shortDescriptionCount');

    });

    $('#meta_title').keyup(function(){

        updateCounter(this,'#metaTitleCount');

    });

    $('#meta_description').keyup(function(){

        updateCounter(this,'#metaDescriptionCount');

    });

    // ==========================================================
    // Clear Validation
    // ==========================================================

    function clearValidationErrors(){

        $('.is-invalid').removeClass('is-invalid');

        $('[class$="_error"]').html('');

        if($('#cke_description').length){

            $('#cke_description').css('border','');

        }

    }

    // ==========================================================
    // Reset Button
    // ==========================================================

    function resetButton(btn){

        btn.prop('disabled',false);

        btn.html(`
            <i class="ti ti-device-floppy me-1"></i>
            {{ isset($blog) ? 'Update Blog' : 'Save Blog' }}
        `);

    }

        // ==========================================================
    // AJAX Submit
    // ==========================================================

    $('#blogForm').submit(function (e) {

        e.preventDefault();

        // CKEditor Update
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

            // ======================================================
            // Success
            // ======================================================

            success: function (response) {

                resetButton(btn);

                toastr.success(
                    response.message ??
                    'Blog saved successfully.'
                );

                setTimeout(function () {

                    window.location.href = "{{ route('blogs.index') }}";

                }, 500);

            },

            // ======================================================
            // Error
            // ======================================================

            error: function (xhr) {

                resetButton(btn);

                // Validation Error
                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {

                        $('[name="' + field + '"]')
                            .addClass('is-invalid');

                        $('.' + field + '_error')
                            .html(messages[0]);

                    });

                    // CKEditor Border
                    if (errors.description) {

                        $('#cke_description').css(
                            'border',
                            '1px solid #ea5455'
                        );

                    }

                    toastr.warning(
                        "Please fill all required fields."
                    );

                    return;

                }

                // Unauthorized
                if (xhr.status === 403) {

                    toastr.error(
                        xhr.responseJSON.message ??
                        'You are not authorized.'
                    );

                    return;

                }

                // Not Found
                if (xhr.status === 404) {

                    toastr.error(
                        xhr.responseJSON.message ??
                        'Record not found.'
                    );

                    return;

                }

                // Internal Server Error
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
