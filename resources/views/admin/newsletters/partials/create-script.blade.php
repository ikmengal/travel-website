<script>
    $(function () {
        // ---------------- Status ---------------- //
        $('#status').change(function () {
            if ($(this).val() == 0) {
                $('.unsubscribe-fields').removeClass('d-none');
            } else {
                $('.unsubscribe-fields').addClass('d-none');
            }
        });

        // ---------------- Submit ---------------- //
        $('#subscriberForm').submit(function (e) {
            e.preventDefault();
            $('.error-text').text('');
            let btn = $(this).find('button[type=submit]');
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('newsletter_subscribers.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    toastr.success(response.message);
                    window.location.href = "{{ route('newsletter_subscribers.index') }}";
                },
                error: function (xhr) {
                    btn.prop('disabled', false);
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                    }
                }
            });
        });
    });
</script>
