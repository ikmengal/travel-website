<script>
    $(function () {
        let table = $('#reviewTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[10, 'desc']],
            ajax: {
                url: "{{ route('reviews.index') }}",
                data: function (d) {
                    d.loaddata = "yes";
                    d.reviewable_type = $('#review_type_filter').val();
                    d.reviewable_id = $('#related_item_filter').val();
                    d.rating = $('#rating_filter').val();
                    d.status = $('#status_filter').val();
                    d.verified = $('#verified_filter').val();
                    d.featured = $('#featured_filter').val();
                    d.search = $('#search').val();
                }
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'type',
                    name: 'reviewable_type'
                },
                {
                    data: 'related',
                    name: 'reviewable_id'
                },
                {
                    data: 'user',
                    name: 'user.name'
                },
                {
                    data: 'rating',
                    name: 'rating'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'verified',
                    name: 'is_verified',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'featured',
                    name: 'is_featured',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [
                {
                    targets: [0,1,8,9,10,11],
                    className: 'text-center'
                },
                {
                    targets: [5],
                    className: 'text-center fw-bold text-warning'
                }
            ],
            language: {
                processing:
                    '<div class="spinner-border text-primary"></div>'
            }
        });

        // ----------------- Search ----------------- //
        $('#search').on('keyup', function () {
            table.draw();
        });

        // ----------------- Filters ----------------- //
        $('#review_type_filter').on('change', function () {
            let type = $(this).val();

            $('#related_item_filter').html(
                '<option value="">Loading...</option>'
            );

            if (type == '') {
                $('#related_item_filter').html(
                    '<option value="">All</option>'
                );
                table.draw();
                return;
            }

            $.ajax({
                url: "{{ route('reviews.get-models') }}",
                type: "GET",
                data: {
                    type: type
                },
                success: function (response) {
                    let options = '<option value="">All</option>';
                    $.each(response, function (index, item) {
                        options += `<option value="${item.id}">
                                        ${item.title ?? item.name}
                                    </option>`;
                    });
                    $('#related_item_filter')
                        .html(options)
                        .trigger('change.select2');
                }
            });
            table.draw();
        });

        $('#related_item_filter').on('change', function () {
            table.draw();
        });

        $('#rating_filter').on('change', function () {
            table.draw();
        });

        $('#status_filter').on('change', function () {
            table.draw();
        });

        $('#verified_filter').on('change', function () {
            table.draw();
        });

        $('#featured_filter').on('change', function () {
            table.draw();
        });

        // ----------------- Reload Table ----------------- //
        $('#reloadTable').on('click', function () {
            table.ajax.reload(null, false);
        });

        // ----------------- Reset Filters ----------------- //
        $('#resetFilters').on('click', function () {
            $('#search').val('');
            $('#review_type_filter').val('').trigger('change');
            $('#related_item_filter').html('<option value="">All</option>').trigger('change');
            $('#rating_filter').val('');
            $('#status_filter').val('');
            $('#verified_filter').val('');
            $('#featured_filter').val('');
            table.draw();
        });

        // ----------------- CHECK ALL ----------------- //
        $('#checkAll').on('click', function () {
            $('.row-checkbox').prop('checked', $(this).is(':checked'));
            toggleBulkDelete();
        });

        $(document).on('change', '.row-checkbox', function () {
            $('#checkAll').prop(
                'checked',
                $('.row-checkbox:checked').length == $('.row-checkbox').length
            );
            toggleBulkDelete();
        });

        function toggleBulkDelete() {
            let count = $('.row-checkbox:checked').length;

            if (count > 0) {
                $('#bulkDeleteBtn').removeClass('d-none');
            } else {
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // ----------------- STATUS ----------------- //
        $(document).on('change', '.changeStatus', function () {
            $.ajax({
                url: "{{ route('reviews.change-status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update status.');
                }
            });
        });

        // ----------------- VERIFIED ----------------- //
        $(document).on('change', '.changeVerified', function () {
            $.ajax({
                url: "{{ route('reviews.change-verified') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update verification.');
                }
            });
        });

        // ----------------- FEATURED ----------------- //
        $(document).on('change', '.changeFeatured', function () {
            $.ajax({
                url: "{{ route('reviews.change-featured') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function () {
                    toastr.error('Unable to update featured status.');
                }
            });
        });

        // ----------------- DELETE ----------------- //
        $(document).on('click', '.deleteRecord', function () {
            let url = $(this).data('url');

            Swal.fire({
                title: 'Delete Review?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Delete failed.');
                        }
                    });
                }
            });
        });

        // ----------------- BULK DELETE ----------------- //
        $('#bulkDeleteBtn').on('click', function () {
            let ids = [];

            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                toastr.warning('Please select at least one review.');
                return;
            }

            Swal.fire({
                title: 'Delete Selected Reviews?',
                text: ids.length + ' review(s) will be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('reviews.bulk-delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            $('#bulkDeleteBtn').addClass('d-none');
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            toastr.error('Bulk delete failed.');
                        }
                    });
                }
            });
        });

        // ----------------- SELECT2 ----------------- //
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
