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

        // ------------ Datatable ------------ //
        let table = $('#blogCategoryDatatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            searching: false,
            lengthChange: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('blog_categories.index') }}",
                type: "GET",
                data: function (d) {
                    d.search = $('#search').val();
                    d.status = $('#status_filter').val();
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'sort_order',
                    name: 'sort_order'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ],
            order: [[6, 'desc']],
            drawCallback: function () {
                $('#checkAll').prop('checked', false);
                $('#bulkDelete').addClass('d-none');
            }
        });

        // ------------ Search ------------ //
        $('#search').keyup(function () {
            table.draw();
        });

        // ------------ Status Filter ------------ //
        $('#status_filter').change(function () {
            table.draw();
        });

        // ------------ Reset Filter ------------ //
        $('#resetFilter').click(function () {
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            table.draw();
        });

        // ------------ Check All ------------ //
        $(document).on('change', '#checkAll', function () {
            $('.record-checkbox').prop('checked', this.checked);
            toggleBulkDelete();
        });

        $(document).on('change', '.record-checkbox', function () {
            toggleBulkDelete();
        });

        function toggleBulkDelete()
        {
            let checked = $('.record-checkbox:checked').length;
            if (checked > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // ------------ Change Status ------------ //
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('blog_categories.change-status') }}",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                    table.ajax.reload(null, false);
                }
            });
        });

        // ------------ Delete Record ------------ //
        $(document).on('click', '.deleteRecord', function () {
            let url = $(this).data('url');

            Swal.fire({
                title: 'Delete Category?',
                text: "This record will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });

        // ------------ Bulk Delete ------------ //
        $('#bulkDelete').click(function () {
            let ids = [];

            $('.record-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                toastr.warning('Please select at least one record.');
                return;
            }

            Swal.fire({
                title: 'Delete Selected?',
                text: ids.length + " categories will be deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('blog_categories.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            $('#bulkDelete').addClass('d-none');
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });
    });
</script>
