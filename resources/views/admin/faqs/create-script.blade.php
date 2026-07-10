<script>
    $(function () {
        // --------------- SELECT2 --------------- //
        $('.select2').select2({
            width: '100%'
        });

        // --------------- CKEDITOR --------------- //
        if($('#answer').length){
            CKEDITOR.replace('answer');
        }

        // --------------- LOAD RELATED ITEMS --------------- //
        $('#faqable_type').change(function () {
            let type = $(this).val();
            $('#faqable_id').html('<option>Loading...</option>');

            if (type == '') {
                $('#faqable_id').html('<option value="">Select Type First</option>');
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
                    let html = '<option value="">Select Item</option>';
                    $.each(response, function (key, item) {
                        html +=
                            '<option value="' + item.id + '">' +
                            item.title +
                            '</option>';
                    });
                    $('#faqable_id').html(html);
                }
            });
            let text = $("#faqable_type option:selected").text();
            $('#previewType').text(text);
        });

        // --------------- RELATED ITEM PREVIEW --------------- //
        $('#faqable_id').change(function () {
            let item = $("#faqable_id option:selected").text();
            $('#previewItem').text(item);
        });

        // --------------- QUESTION PREVIEW --------------- //
        $('#question').keyup(function () {
            let value = $(this).val();

            if (value == '') {
                value = 'Your FAQ question will appear here...';
            }
            $('#previewQuestion').text(value);
        });

        // --------------- FORM VALIDATION --------------- //
        $('#faqForm').submit(function () {
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

            let answer = $('#answer').summernote('code');

            if (answer == '' || answer == '<p><br></p>') {
                toastr.error('Answer is required');
                return false;
            }
        });

        // --------------- CHARACTER COUNTER --------------- //
        $('#question').on('keyup', function () {
            let len = $(this).val().length;

            if ($('#questionCount').length == 0) {
                $(this).after(
                    '<small id="questionCount" class="text-muted"></small>'
                );
            }
            $('#questionCount').html(len + ' / 255 Characters');
        });
    });
</script>
