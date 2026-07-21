<script>
    $(function () {
        // -------------- CSRF Token -------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------- Select2 -------------- //
        $('.select2').select2({
            width: '100%'
        });

        // -------------- DataTable -------------- //
        let table = $('#blogTagsDatatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            ordering: true,
            searching: false,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: "{{ route('blog_tags.index') }}",
                type: "GET",
                data: function(d) {
                    d.search = $('#search').val();
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'blogs_count',
                    name: 'blogs_count',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
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
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [5, 'desc']
            ],
            drawCallback: function() {
                $('#checkAll').prop('checked', false);
                $('#bulkDelete').addClass('d-none');
            }
        });

        // -------------- Search -------------- //
        $('#search').keyup(function () {
            table.ajax.reload();
        });

        // -------------- Status Filter -------------- //
        $('#status_filter').change(function () {
            table.ajax.reload();
        });

        // -------------- Date Filters -------------- //
        $('#date_from').change(function () {
            table.ajax.reload();
        });

        $('#date_to').change(function () {
            table.ajax.reload();
        });

        // -------------- Check All -------------- //
        $('#checkAll').on('change', function () {
            $('.record-checkbox').prop('checked', this.checked);
            toggleBulkDelete();
        });

        $(document).on('change', '.record-checkbox', function () {
            toggleBulkDelete();
        });

        function toggleBulkDelete() {
            let checked = $('.record-checkbox:checked').length;
            let total = $('.record-checkbox').length;

            $('#checkAll').prop(
                'checked',
                checked === total && total > 0
            );

            if (checked > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // -------------- Reset Filters -------------- //
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            $('#date_from').val('');
            $('#date_to').val('');
            table.ajax.reload();
        });

        // -------------- Change Status -------------- //
        $(document).on('change', '.changeStatus', function () {
            let checkbox = $(this);

            $.ajax({
                url: "{{ route('blog_tags.change-status') }}",
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
                        toastr.error(xhr.responseJSON.message ??
                            'You are not authorized.');
                        return;
                    }
                    if (xhr.status === 422) {
                        toastr.error('Validation failed.');
                        return;
                    }
                    toastr.error('Unable to update status.');
                }
            });
        });

        // -------------- Delete Record -------------- //
        $(document).on('click', '.deleteRecord', function () {
            let url = $(this).data('url');

            Swal.fire({
                title: 'Delete Tag?',
                text: 'This action cannot be undone.',
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
                            _method: "DELETE"
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
                            toastr.error('Unable to delete tag.');
                        }
                    });
                }
            });
        });

        // -------------- Bulk Delete -------------- //
        $('#bulkDelete').click(function () {
            let ids = [];

            $('.record-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one tag.');
                return;
            }
            Swal.fire({
                title: 'Delete Selected Tags?',
                text: 'Selected tags will be permanently deleted.',
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
                        url: "{{ route('blog_tags.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $('#bulkDelete').addClass('d-none');
                            $('#checkAll').prop('checked', false);
                        },
                        error: function (xhr) {
                            if (xhr.status === 403) {
                                toastr.error(xhr.responseJSON.message);
                                return;
                            }
                            if (xhr.status === 422) {
                                toastr.error('Please select valid records.');
                                return;
                            }
                            toastr.error('Bulk delete failed.');
                        }
                    });
                }
            });
        });
    });
</script>
