<script>
    $(function () {
        // ------------------- Status ------------------- //
        function toggleFields() {
            if ($('#status').val() == 0) {
                $('.unsubscribe-fields').removeClass('d-none');
            } else {
                $('.unsubscribe-fields').addClass('d-none');
            }
        }

        toggleFields();
        $('#status').change(function () {
            toggleFields();
        });

        // ------------------- Submit ------------------- //
        $('#subscriberForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            $('.error-text').text('');
            let btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success:function(response){
                    btn.prop('disabled',false);
                    toastr.success(response.message);
                    window.location.href="{{ route('newsletter_subscribers.index') }}";
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
