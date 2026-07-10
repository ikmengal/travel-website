<script>
    $(function () {
        // --------------------- Select2 --------------------- //
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option'
        });

        // --------------------- CKEditor 4 --------------------- //
        if ($('#review').length) {
            CKEDITOR.replace('review', {
                height: 250,
                removeButtons: 'PasteFromWord'
            });
        }

        // --------------------- Review Type -> Related Item --------------------- //
        $('#reviewable_type').on('change', function () {
            let type = $(this).val();

            $('#reviewable_id').html(
                '<option value="">Loading...</option>'
            );

            if (type == '') {
                $('#reviewable_id').html(
                    '<option value="">Select Item</option>'
                );
                return;
            }

            $.ajax({
                url: "{{ route('reviews.get-models') }}",
                type: "GET",
                data: {
                    type: type
                },
                success: function (response) {
                    let options = '<option value="">Select Item</option>';
                    $.each(response, function (index, item) {
                        let selected = item.id == "{{ old('reviewable_id', $review->reviewable_id) }}"
                            ? 'selected'
                            : '';
                        options += `
                            <option value="${item.id}" ${selected}>
                                ${item.title ?? item.name}
                            </option>
                        `;
                    });
                    $('#reviewable_id').html(options).trigger('change');
                },
                error: function () {
                    toastr.error('Unable to load related items.');
                    $('#reviewable_id').html(
                        '<option value="">Select Item</option>'
                    );
                }
            });
        });

        // --------------------- Load Selected Items On Page Load --------------------- //
        if ($('#reviewable_type').val() != '') {
            $('#reviewable_type').trigger('change');
        }

        // --------------------- Status => Approved At --------------------- //
        $('#status').on('change', function () {
            if ($(this).is(':checked')) {
                if ($('input[name="approved_at"]').val() == '') {
                    let now = new Date();
                    let offset = now.getTimezoneOffset();
                    now = new Date(now.getTime() - (offset * 60 * 1000));
                    $('input[name="approved_at"]').val(now.toISOString().slice(0,16));
                }
            } else {
                $('input[name="approved_at"]').val('');
            }
        });

        // --------------------- Character Counter --------------------- //
        $('input[name="title"]').on('keyup', function () {
            let count = $(this).val().length;
            if ($('#titleCounter').length == 0) {
                $(this).after(
                    '<small id="titleCounter" class="text-muted d-block mt-1"></small>'
                );
            }
            $('#titleCounter').html(count + ' / 255 Characters');
        }).trigger('keyup');

        // --------------------- Submit Validation --------------------- //
        $('#reviewForm').on('submit', function () {
            if (CKEDITOR.instances.review) {
                $('#review').val(
                    CKEDITOR.instances.review.getData()
                );
            }

            if ($('#reviewable_type').val() == '') {
                toastr.warning('Please select review type.');
                return false;
            }

            if ($('#reviewable_id').val() == '') {
                toastr.warning('Please select related item.');
                return false;
            }

            if ($('#user_id').val() == '') {
                toastr.warning('Please select customer.');
                return false;
            }

            if ($('select[name="rating"]').val() == '') {
                toastr.warning('Please select rating.');
                return false;
            }

            if (CKEDITOR.instances.review.getData().trim() == '') {
                toastr.warning('Review is required.');
                return false;
            }
        });
    });
</script>
