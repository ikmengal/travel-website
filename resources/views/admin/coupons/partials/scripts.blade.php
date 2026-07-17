<script>
    $(function () {
        // --------------- CSRF --------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // --------------- DataTable --------------- //
        let table = $('#couponTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            pageLength: 25,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('coupons.index') }}",
                data: function (d) {
                    d.loaddata = 'yes';
                    d.status = $('#status_filter').val();
                    d.type = $('#type_filter').val();
                    d.starts_at = $('#starts_at_filter').val();
                    d.expires_at = $('#expires_at_filter').val();
                    d.search = $('input[type="search"]').val();
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
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'minimum_amount',
                    name: 'minimum_amount'
                },
                {
                    data: 'maximum_discount',
                    name: 'maximum_discount'
                },
                {
                    data: 'usage_limit',
                    name: 'usage_limit'
                },
                {
                    data: 'used',
                    name: 'used'
                },
                {
                    data: 'starts_at',
                    name: 'starts_at'
                },
                {
                    data: 'expires_at',
                    name: 'expires_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function () {
                $('#checkAll').prop('checked', false);
                toggleBulkDelete();
            }
        });

        // --------------- Filters --------------- //
        $('#refreshFilters').click(function () {
            $('#status_filter').val('').trigger('change');
            $('#type_filter').val('').trigger('change');
            $('#starts_at_filter').val('');
            $('#expires_at_filter').val('');

            $('#checkAll').prop('checked', false);
            table.ajax.reload();
        });

        $('#status_filter, #type_filter').change(function () {
            table.ajax.reload();
        });

        $('#starts_at_filter, #expires_at_filter').change(function () {
            table.ajax.reload();
        });

        // --------------- Check All ---------------//
        $(document).on('change', '#checkAll', function () {
            $('.checkBoxClass').prop('checked', $(this).is(':checked'));
            toggleBulkDelete();
        });

        // --------------- Single Checkbox ---------------//
        $(document).on('change', '.checkBoxClass', function () {
            let total = $('.checkBoxClass').length;
            let checked = $('.checkBoxClass:checked').length;

            $('#checkAll').prop('checked', total > 0 && total === checked);
            toggleBulkDelete();
        });

        // --------------- Toggle Bulk Delete Button ---------------//
        function toggleBulkDelete()
        {
            let checked = $('.checkBoxClass:checked').length;

            if (checked > 0) {
                $('#bulkDelete').removeClass('d-none');
            } else {
                $('#bulkDelete').addClass('d-none');
            }
        }

        // --------------- Delete Record ---------------//
        $(document).on('click', '.deleteRecord', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('coupons.destroy', ':id') }}".replace(':id', id),
                        type: "DELETE",
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });

        // --------------- Bulk Delete ---------------//
        $('#bulkDelete').click(function () {
            let ids = [];

            $('.checkBoxClass:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                toastr.warning('Please select at least one record.');
                return;
            }

            Swal.fire({
                title: 'Delete Selected?',
                text: 'Selected coupons will be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('coupons.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });

        // --------------- Status Change ---------------//
        $(document).on('change', '.changeStatus', function () {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('coupons.change-status') }}",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                beforeSend: function () {
                    $('.changeStatus').prop('disabled', true);
                },
                success: function (response) {
                    toastr.success(response.message);
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(
                        xhr.responseJSON?.message ?? 'Something went wrong.'
                    );
                    table.ajax.reload(null, false);
                },
                complete: function () {
                    $('.changeStatus').prop('disabled', false);
                }
            });
        });

        // --------------- Search ---------------//
        $('input[type="search"]').on('keyup', function () {
            table.ajax.reload();
        });

        // --------------- Reset Bulk Selection on Every Draw ---------------//
        table.on('draw', function () {
            $('#checkAll').prop('checked', false);
            $('#bulkDelete').addClass('d-none');
        });
    });
</script>
