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
        // DataTable
        // ==========================================================
        let table = $('#blogCommentsDatatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            ordering: true,
            searching: false,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10,25,50,100],
                [10,25,50,100]
            ],
            ajax: {
                url: "{{ route('blog_comments.index') }}",
                type: "GET",
                data: function (d) {
                    d.search = $('#search').val();
                    d.blog_id = $('#blog_filter').val();
                    d.status = $('#status_filter').val();
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
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
                    searchable: false
                },
                {
                    data: 'blog',
                    name: 'blog.title'
                },
                {
                    data: 'user',
                    name: 'name'
                },
                {
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'type',
                    name: 'type',
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
            order: [
                [7,'desc']
            ],
            drawCallback: function () {
                $('#checkAll').prop('checked', false);
                $('#bulkDelete').addClass('d-none');
            }
        });

        // ==========================================================
        // Search & Filters
        // ==========================================================
        $('#search').keyup(function () {
            table.ajax.reload();
        });

        $('#blog_filter').change(function () {
            table.ajax.reload();
        });

        $('#status_filter').change(function () {
            table.ajax.reload();
        });

        $('#date_from').change(function () {
            table.ajax.reload();
        });

        $('#date_to').change(function () {
            table.ajax.reload();
        });

        // ==========================================================
        // Check All
        // ==========================================================
        $('#checkAll').change(function () {
            $('.record-checkbox').prop(
                'checked',
                $(this).prop('checked')
            );
            toggleBulkDelete();
        });

        $(document).on('change', '.record-checkbox', function () {
            toggleBulkDelete();
        });

        function toggleBulkDelete() {
            let total = $('.record-checkbox').length;
            let checked = $('.record-checkbox:checked').length;

            $('#checkAll').prop(
                'checked',
                total === checked && total > 0
            );

            if (checked > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // ==========================================================
        // Reset Filters
        // ==========================================================
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#blog_filter').val('').trigger('change');
            $('#status_filter').val('').trigger('change');
            $('#date_from').val('');
            $('#date_to').val('');
            table.ajax.reload();
        });

        // ==========================================================
        // Change Status
        // ==========================================================
        $(document).on('change', '.changeStatus', function () {
            let checkbox = $(this);
            $.ajax({
                url: "{{ route('blog_comments.change-status') }}",
                type: "POST",
                data: {
                    id: checkbox.data('id'),
                    status: checkbox.is(':checked') ? 1 : 0
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (xhr) {
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    if (xhr.status === 403) {
                        toastr.error(xhr.responseJSON.message);
                        return;
                    }
                    toastr.error("Unable to update status.");
                }
            });
        });

        // ==========================================================
        // Delete Record
        // ==========================================================
        $(document).on('click', '.deleteRecord', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: 'Delete Comment?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            if (xhr.status === 403) {
                                toastr.error(xhr.responseJSON.message);
                                return;
                            }
                            if (xhr.status === 404) {
                                toastr.error(xhr.responseJSON.message);
                                return;
                            }
                            toastr.error("Unable to delete record.");
                        }
                    });
                }
            });
        });

        // ==========================================================
        // Bulk Delete
        // ==========================================================
        $('#bulkDelete').click(function () {
            let ids = [];

            $('.record-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning("Please select at least one comment.");
                return;
            }
            Swal.fire({
                title: 'Delete Selected Comments?',
                text: "Selected comments will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('blog_comments.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $('#bulkDelete').addClass('d-none');
                        },
                        error: function (xhr) {
                            if (xhr.status === 403) {
                                toastr.error(xhr.responseJSON.message);
                                return;
                            }
                            toastr.error("Bulk delete failed.");
                        }
                    });
                }
            });
        });
    });
</script>
