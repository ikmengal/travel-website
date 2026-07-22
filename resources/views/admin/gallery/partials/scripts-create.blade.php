<script>
    $(function () {
        // ------------ CSRF ------------ //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ------------ Select2 ------------ //
        $('.select2').select2({
            width: '100%'
        });

        // ------------ CKEditor 4 ------------ //
        if ($('#description').length) {
            CKEDITOR.replace('description', {
                height: 300,
                removeButtons: '',
                allowedContent: true
            });
        }

        // ------------ Image Preview ------------ //
        $('#image').on('change', function (e) {
            let file = e.target.files[0];
            if (!file) return;
            let reader = new FileReader();

            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });

        // ------------ Auto Slug ------------ //
        $('#title').keyup(function () {
            let slug = $(this).val()
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#slug').val(slug);
        });

        // ------------ Submit ------------ //
        $('#galleryForm').submit(function (e) {
            e.preventDefault();
            $('.error-text').text('');
            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.updateElement();
            }

            let form = this;
            let formData = new FormData(form);
            let btn = $('#submitBtn');

            $('#submitBtn')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.href = "{{ route('gallery.index') }}";
                    }, 800);
                },
                error: function (xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                    }
                },
                complete: function () {
                    $('#submitBtn')
                        .prop('disabled', false)
                        .html('<i class="ti ti-device-floppy me-1"></i>Save Gallery');
                }
            });
        });
    });
</script>
