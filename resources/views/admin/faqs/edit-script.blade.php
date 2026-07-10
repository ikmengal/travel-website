<script>
    $(function () {
        // ------------- SELECT2 ------------- //
        $('.select2').select2({
            width: '100%'
        });

        // ------------- CKEDITOR 4 ------------- //
        if ($('#answer').length) {
            CKEDITOR.replace('answer', {
                height: 300
            });
        }

        // ------------- LOAD RELATED ITEMS ------------- //
        $('#faqable_type').on('change', function () {
            let type = $(this).val();
            $('#faqable_id').html('<option value="">Loading...</option>');

            if (type == '') {
                $('#faqable_id').html('<option value="">Select Related Item</option>');
                $('#previewType').text('--');
                $('#previewItem').text('--');
                return;
            }

            $.ajax({
                url: "{{ route('faqs.get-models') }}",
                type: "GET",
                data: {
                    type: type
                },
                success: function (response) {
                    let html = '<option value="">Select Related Item</option>';
                    $.each(response, function (index, item) {
                        html += '<option value="' + item.id + '">' + item.title + '</option>';
                    });
                    $('#faqable_id').html(html);
                }
            });
            $('#previewType').text($('#faqable_type option:selected').text());
        });

        // ------------- RELATED ITEM PREVIEW ------------- //
        $('#faqable_id').on('change', function () {
            $('#previewItem').text(
                $('#faqable_id option:selected').text()
            );
        });

        // ------------- QUESTION PREVIEW ------------- //
        $('#question').on('keyup', function () {
            let value = $(this).val();

            if (value == '') {
                value = 'Your FAQ Question';
            }
            $('#previewQuestion').text(value);
        });

        // ------------- CHARACTER COUNTER ------------- //
        if ($('#questionCounter').length == 0) {
            $('#question').after(
                '<small id="questionCounter" class="text-muted"></small>'
            );
        }

        $('#question').on('keyup', function () {
            $('#questionCounter').html(
                $(this).val().length + ' / 255 Characters'
            );
        }).trigger('keyup');

        // ------------- FORM VALIDATION ------------- //
        $('#faqForm').submit(function () {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            if ($('#faqable_type').val() == '') {
                toastr.error('Please select FAQ Type');
                return false;
            }

            if ($('#faqable_id').val() == '') {
                toastr.error('Please select Related Item');
                return false;
            }

            if ($('#question').val().trim() == '') {
                toastr.error('Question is required');
                $('#question').focus();
                return false;
            }

            let answer = CKEDITOR.instances.answer.getData().trim();

            if (answer == '') {
                toastr.error('Answer is required');
                return false;
            }
            return true;
        });
    });
</script>
