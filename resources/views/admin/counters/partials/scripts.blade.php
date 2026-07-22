<script>
    $(function () {
        // -------------------- CSRF -------------------- //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------------- Select2 -------------------- //
        $('.select2').select2({
            width: '100%'
        });

        // -------------------- DataTable -------------------- //
        var table = $('#counterTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            autoWidth: false,
            ajax: {
                url: "{{ route('counters.index') }}",
                data: function (d) {
                    d.search = $('#search').val();
                    d.status = $('#status_filter').val();
                }
            },
            order: [[5, 'asc']],
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
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'icon',
                    name: 'icon',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'value',
                    name: 'value',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'sort_order',
                    name: 'sort_order'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // -------------------- Search -------------------- //
        $('#search').keyup(function () {
            table.draw();
        });

        // -------------------- Status Filter -------------------- //
        $('#status_filter').change(function () {
            table.draw();
        });

        // -------------------- Reset Filters -------------------- //
        $('#resetFilters').click(function () {
            $('#search').val('');
            $('#status_filter').val('').trigger('change');
            table.draw();
        });

        // -------------------- Check All -------------------- //
        $(document).on('change', '#checkAll', function () {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
            toggleBulkDelete();
        });

        $(document).on('change', '.row-checkbox', function () {
            $('#checkAll').prop(
                'checked',
                $('.row-checkbox').length === $('.row-checkbox:checked').length
            );
            toggleBulkDelete();
        });

        // -------------------- Toggle Bulk Delete -------------------- //
        function toggleBulkDelete() {
            if ($('.row-checkbox:checked').length > 0) {
                $('#bulkDeleteBtn').removeClass('d-none');
            } else {
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // -------------------- Bulk Delete -------------------- //
        $(document).on('click', '#bulkDeleteBtn', function () {
            let ids = [];
            $('.row-checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            if (ids.length === 0) {
                toastr.warning('Please select at least one counter.');
                return;
            }
            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected counters will be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('counters.bulk-delete') }}",
                        type: "POST",
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#checkAll').prop('checked', false);
                            $('#bulkDeleteBtn').addClass('d-none');
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Something went wrong.');
                        }
                    });
                }
            });
        });

        // -------------------- Status Change -------------------- //
        $(document).on('change', '.changeStatus', function () {
            $.ajax({
                url: "{{ route('counters.change-status') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    status: $(this).is(':checked') ? 1 : 0
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

        // -------------------- Delete -------------------- //
        $(document).on('click', '.deleteCounter', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: 'Delete Counter?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message ?? 'Delete failed.');
                        }
                    });
                }
            });
        });
    });
</script>
