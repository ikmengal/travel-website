<script>
    $(function () {
        // ===================== CSRF ===================== //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ===================== Select2 ===================== //
        $('.select2').select2({
            width: '100%'
        });

        // ===================== Image Preview ===================== //
        $('#image').on('change', function () {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // ===================== Auto Slug ===================== //
        $('#name').on('keyup', function () {
            @if(!isset($teamMember))
            let slug = $(this).val()
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-');
            $('#slug').val(slug);
            @endif
        });

        // ===================== Clear Validation ===================== //
        function clearErrors() {
            $('.error-text').html('');
            $('.form-control').removeClass('is-invalid');
            $('.form-select').removeClass('is-invalid');
        }

        // ===================== Submit ===================== //
        $('#teamMemberForm').on('submit', function (e) {
            e.preventDefault();
            clearErrors();
            let form = this;
            let formData = new FormData(form);
            let btn = $('#submitBtn');
            btn.prop('disabled', true);
            btn.html(
                '<span class="spinner-border spinner-border-sm me-1"></span>Saving...'
            );
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    toastr.success(response.message);
                    window.location.href = "{{ route('team_members.index') }}";
                },
                error: function (xhr) {
                    btn.prop('disabled', false);
                    btn.html(
                        '<i class="ti ti-device-floppy me-1"></i> {{ isset($teamMember) ? "Update Team Member" : "Save Team Member" }}'
                    );
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('[name="' + key + '"]').addClass('is-invalid');
                            $('.' + key + '_error').html(value[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                    }
                }
            });
        });
    });
</script>
